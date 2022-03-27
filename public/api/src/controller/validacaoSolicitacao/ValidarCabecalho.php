<?php

namespace Alvescbjr\API\controller\validacaoSolicitacao;

use Alvescbjr\API\controller\validacaoSolicitacao\ValidarSolicitacao;

final class ValidarCabecalho extends ValidarSolicitacao
{
    CONST AUTHORIZATION         = "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.CNvBJJ6ebLtFr9xB3mr1iCiiRZBXvpemJRLKTcQvgJ8";
    CONST DEFAULTCONTENTTYPE    = "application/json";
    private array $headers;

    public function __construct(ValidarSolicitacao $proximaValidacao, array $headers)
    {
        parent::__construct($proximaValidacao);
        $this->headers = $headers;
    }

    public function validar() : array
    {
        if (isset($this->headers["authorization"]) === false 
         || isset($this->headers["content-type"]) === false) {

            http_response_code(401);
            return [
                "status" => false,
                "detalhes" => "content-type e/ou token ausente(s)"
            ];
        }

        if ($this->headers["authorization"] !== ValidarCabecalho::AUTHORIZATION 
         || $this->headers["content-type"] !== ValidarCabecalho::DEFAULTCONTENTTYPE) {
            http_response_code(401);
            return [
                "status"    => false,
                "detalhes"  => "content-type e/ou token inválido(s)"
            ];
        }

        return $this->proximaValidacao->validar();
    }
}