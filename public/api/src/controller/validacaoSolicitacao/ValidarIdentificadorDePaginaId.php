<?php

namespace Alvescbjr\API\controller\validacaoSolicitacao;

use Alvescbjr\API\controller\validacaoSolicitacao\ValidarSolicitacao;

final class ValidarIdentificadorDePaginaId extends ValidarSolicitacao
{
    private int $identificador;
    private string $metodoHttp;

    public function __construct(ValidarSolicitacao $proximaValidacao, string $metodoHttp, int $identificador)
    {
        parent::__construct($proximaValidacao);
        $this->metodoHttp = $metodoHttp;
        $this->identificador = $identificador;
    }

    public function validar(): array
    {
        if ($this->identificador <= 0 && $this->metodoHttp !== "POST") {
            
            http_response_code(422);
            return [
                "status"    => false,
                "datalhes"  => "Identificador de página ou ID ausente!"
            ];
        }

        if ($this->identificador > 0 && $this->metodoHttp === "POST") {
            
            http_response_code(422);
            return [
                "status"    => false,
                "detalhes"  => "Uso incorreto de identificador de página ou ID!"
            ];
        }

        return $this->proximaValidacao->validar();
    }
}