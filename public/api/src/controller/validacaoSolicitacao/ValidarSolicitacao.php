<?php

namespace Alvescbjr\API\controller\validacaoSolicitacao;

abstract class ValidarSolicitacao
{
    protected ?ValidarSolicitacao $proximaValidacao;

    public function __construct(?ValidarSolicitacao $proximaValidacao)
    {
        $this->proximaValidacao = $proximaValidacao;
    }

    abstract public function validar() : array;
}