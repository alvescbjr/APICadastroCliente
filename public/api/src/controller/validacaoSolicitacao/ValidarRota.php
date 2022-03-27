<?php

namespace Alvescbjr\API\controller\validacaoSolicitacao;

use Alvescbjr\API\controller\validacaoSolicitacao\ValidarSolicitacao;

final class ValidarRota extends ValidarSolicitacao
{
    private string $rota;

    public function __construct(ValidarSolicitacao $proximaValidacao, string $rota)
    {
        parent::__construct($proximaValidacao);
        $this->rota = $rota;
    }

    public function validar(): array
    {
        if (empty($this->rota)) {
            http_response_code(404);
            return [
                "status"    => false,
                "detalhes"  => "Not found!"
            ];
        }

        $rotas = require_once __DIR__ . "/../../../config/rotas.php";

        if (array_key_exists($this->rota, $rotas) === false) {
            http_response_code(404);
            return [
                "status"    => false,
                "detalhes"  => "Not found!"
            ];
        }

        return $this->proximaValidacao->validar();
    }
}