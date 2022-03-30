<?php

namespace Alvescbjr\ApiCadastroCliente\entity\clientes;

use Alvescbjr\ApiCadastroCliente\entity\contato\EntidadeTelefone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 */
class EntidadeCliente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;
    /**
     * @ORM\Column(type="string")
     */
    private string $nome;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $cpf;
    /**
     * @ORM\Column(type="date", name="data_nascimento")
     */
    private DateTime $dataNascimento;
    /**
     * @ORM\OneToMany(targetEntity=EntidadeTelefone::class, mappedBy="cliente", cascade={"remove", "persist"})
     */
    private Collection $telefones;

    public function __construct()
    {
        $this->telefones = new ArrayCollection();
    }

    public function getId() : int
    {
        return $this->id;
    }
    
    public function getNome() : string
    {
        return $this->nome;
    }
    public function setNome(string $nome) : self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getCpf() : string
    {
        return $this->cpf;
    }
    public function setCpf(string $cpf) : self
    {
        $cpf = str_replace([".", ",", "-", "/", "\\"], "", $cpf);
        $this->cpf = $cpf;
        return $this;
    }

    public function getDataNascimento() : string
    {
        return $this->dataNascimento->format('d-m-Y');
    }
    public function setDataNascimento(string $dataNascimento) : self
    {
        $dataNascimento = str_replace(["/",], "-", $dataNascimento);

        $data = new DateTime($dataNascimento);
        $this->dataNascimento = $data;
        return $this;
    }

    public function getTelefones(): Collection
    {
        return $this->telefones;
    }
    public function addTelefone(EntidadeTelefone $telefone) : self
    {
        $this->telefones->add($telefone);
        $telefone->setCliente($this);
        return $this;
    }

}