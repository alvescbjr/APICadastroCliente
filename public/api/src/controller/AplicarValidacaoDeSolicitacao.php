<?php

namespace Alvescbjr\API\controller;

use Alvescbjr\API\controller\validacaoSolicitacao\{
    ValidarCabecalho,
    ValidarRota,
    ValidarCorpoDaSolicitacao,
    ValidarIdentificadorDePaginaId,
    ValidacaoCompleta
};

final class AplicarValidacaoDeSolicitacao
{
    public function validarSolicitacao(string $rota, array $headers, string $metodoHttp, string $corpoDaSolicitacao, int $idOuPagina) : array
    {
        $cadeiaDeValidacao = new ValidarCabecalho(
            new ValidarRota(
                new ValidarCorpoDaSolicitacao(
                    new ValidarIdentificadorDePaginaId(
                        new ValidacaoCompleta(), 
                        $metodoHttp, 
                        $idOuPagina
                    ),
                    $metodoHttp, 
                    $corpoDaSolicitacao
                ), 
                $rota
            ),
            $headers
        );

        return $cadeiaDeValidacao->validar();
    }
}