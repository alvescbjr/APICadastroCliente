<?php

namespace Alvescbjr\API\controller\validacaoSolicitacao;

use Alvescbjr\API\controller\validacaoSolicitacao\ValidarSolicitacao;

final class ValidarCorpoDaSolicitacao extends ValidarSolicitacao
{
    private string $metodoHttp;
    private string $corpoDaSolicitacao;

    public function __construct(ValidarSolicitacao $proximaValidacao, string $metodoHttp, string $corpoDaSolicitacao)
    {
        parent::__construct($proximaValidacao);
        $this->metodoHttp           = $metodoHttp;
        $this->corpoDaSolicitacao   = $corpoDaSolicitacao;
    }

    public function validar() : array
    {
        if ($this->metodoHttp === "POST" || $this->metodoHttp === "PUT") {
            if (empty($this->corpoDaSolicitacao)) {
                
                http_response_code(422);
                return [
                    "status"    => false,
                    "detalhes"  => "Requisição Inválida! Corpo Vazio!"
                ];
            }
        }

        return $this->proximaValidacao->validar();
    }
}