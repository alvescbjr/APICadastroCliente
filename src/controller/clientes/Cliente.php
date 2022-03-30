<?php

namespace Alvescbjr\ApiCadastroCliente\controller\clientes;

use Alvescbjr\ApiCadastroCliente\entity\contato\EntidadeTelefone;
use Alvescbjr\ApiCadastroCliente\entity\clientes\EntidadeCliente;
use Alvescbjr\ApiCadastroCliente\interfaces\ControleDeSolicitacoesAPI;
use Alvescbjr\ApiCadastroCliente\helpers\EntityManagerFactory;
use Alvescbjr\ApiCadastroCliente\trait\APIRecursos;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PDOException;
use RuntimeException;

final class Cliente implements ControleDeSolicitacoesAPI
{
    /** @var EntityManagerInterface $entityManager*/
    private EntityManagerInterface $entityManager;

    use APIRecursos;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerFactory())->getEntityManager();
    }

    public function findBy(int $page): array
    {
        try {
            $repositorioCliente = $this->entityManager->getRepository(EntidadeCliente::class);
            $offset             = $this->offset($page);
            $lista              = $repositorioCliente->findBy([], [], 10, $offset);

            if (sizeof($lista) <= 0) {
                return [
                    "status"    => true,
                    "detalhes"  => "Sem registros!"
                ];
            }

            $arrClientes["pagination"]  = $this->paginacao(EntidadeCliente::class);
            $arrClientes["status"]      = true;
            $arrClientes["results"]     = [];

            foreach ($lista as $cliente) {

                array_push($arrClientes["results"], [
                    "id"                => $cliente->getId(),
                    "nome"              => $cliente->getNome(),
                    "cpf"               => $cliente->getCpf(),
                    "data_nascimento"   => $cliente->getDataNascimento(),
                    "telefones"         => $this->tratarCollectionTelefones($cliente->getTelefones())
                ]);
            }

            return $arrClientes;
        } catch(Exception $e) {
            return [
                "status"    => false,
                "detalhes"  => "Não foi possível realizar a listagem!",
                "ex"        => $e->getMessage()
            ];
        }
    }

    public function findOneBy(int $id): array
    {
        try {

            $repositorioCliente = $this->entityManager->getRepository(EntidadeCliente::class);
            $cliente            = $repositorioCliente->findOneBy(["id" => $id]);

            if (is_null($cliente)) {
                return [
                    "status"    => false,
                    "detalhes"  => "Cliente não encontrado!"
                ];
            }

            $infoCliente                                = [];
            $infoCliente["status"]                      = true;
            $infoCliente["results"]["id"]               = $cliente->getId();
            $infoCliente["results"]["nome"]             = $cliente->getNome();
            $infoCliente["results"]["cpf"]              = $cliente->getCpf();
            $infoCliente["results"]["data_nascimento"]  = $cliente->getDataNascimento();
            $infoCliente["results"]["telefones"]        = $this->tratarCollectionTelefones($cliente->getTelefones());

            return $infoCliente;

        } catch(Exception $e) {
            return [
                "status"    => false,
                "detalhes"  => "Não foi possível realizar a consulta!"
            ];
        }
    }

    public function insert(array $data): array
    {
        try {
            $novoCliente    = new EntidadeCliente();

            $this->tratarArrayDeTelefones($novoCliente, $data["telefones"]);

            $novoCliente->setNome($data["nome"])
            ->setCpf($data["cpf"])
            ->setDataNascimento($data["data_nascimento"]);

            $this->entityManager->persist($novoCliente);
            $this->entityManager->flush();

            return [
                "status"    => true,
                "detalhes"  => "Cliente cadastrado com sucesso! ID: {$novoCliente->getId()}"
            ];

        }catch (Exception $e) {
            $detalhes = "Não foi possível realizar o cadastro! " . $this->tratarExceptionNaInsercao($e->getMessage());

            return [
                "status"    => false,
                "detalhes"  => $detalhes,
                "ex"        => $e->getMessage()
            ];
        }
    }

    public function update(int $id, array $data): array
    {
        return [];
    }

    public function remove(int $id): array
    {
        return [];
    }

    private function tratarArrayDeTelefones(EntidadeCliente &$novoCliente, array $telefones) : void
    {
        if (is_array($telefones) === false) {
            return;
        }
        
        foreach ($telefones as $telefone) {
            $novoTelefone   = new EntidadeTelefone();
            $novoTelefone->setNumero($telefone);

            $novoCliente->addTelefone($novoTelefone);
        }
    } 
    /**
     * Se a exception possuir a palavra violação é retornado
     */
    private function tratarExceptionNaInsercao(string $exception) : string
    {
        $pattern = "/\bviolation:[\s\w]+/";
        preg_match($pattern, $exception, $erro);

        return implode("", $erro);
    }

    /**
     * @throws RuntimeException
     */
    private function tratarCollectionTelefones(object $colecao) : array
    {
        if (!$colecao instanceof Collection) {
            throw new RuntimeException("Não foi possível realizar o tratamento da collection");
        }

        $cont = 0;

        return $colecao->map(function(EntidadeTelefone $telefone) use (&$cont){
            $cont += 1;
            return [
                    "id"                => $telefone->getId(),
                    "telefone_{$cont}"  => $telefone->getNumero()
                ];
        })->toArray();
    }

}