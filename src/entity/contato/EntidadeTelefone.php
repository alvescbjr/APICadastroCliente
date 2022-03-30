<?php

namespace Alvescbjr\ApiCadastroCliente\entity\contato;

use Alvescbjr\ApiCadastroCliente\entity\clientes\EntidadeCliente;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="telefone")
 */
class EntidadeTelefone
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
    private string $numero;
    /**
     *@ORM\ManyToOne(targetEntity=EntidadeCliente::class)
     */
    private EntidadeCliente $cliente;

    public function getId() : int
    {
        return $this->id;
    }

    public function getNumero() : string
    {
        return $this->numero;
    }
    public function setNumero(string $numero) : self
    {
        $this->numero = $numero;
        return $this;
    }

    public function getCliente() : EntidadeCliente
    {
        return $this->cliente;
    }
    public function setCliente(EntidadeCliente $cliente) : self
    {
        $this->cliente = $cliente;
        return $this;
    }

}