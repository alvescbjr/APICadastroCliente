<?php

namespace Alvescbjr\API\controller\validacaoSolicitacao;

use Alvescbjr\API\controller\validacaoSolicitacao\ValidarSolicitacao;

final class ValidacaoCompleta extends ValidarSolicitacao
{
    public function __construct()
    {
        parent::__construct(null);
    }

    public function validar(): array
    {
        return ["status" => true];
    }
}