<?php

namespace Alvescbjr\ApiCadastroCliente\trait;

trait APIRecursos
{
    private function paginacao(string $entidade) : int
    {
        $dql = "SELECT COUNT(E) FROM {$entidade} E";

        $query      = $this->entityManager->createQuery($dql);
        $paginacao  = $query->getSingleScalarResult();

        $paginacao = ceil($paginacao / 10);
        return intval($paginacao);
    }

    private function offset(int $pagina) : int
    {
        if ($pagina === 1) {
            return 0;
        }

        return $pagina * 10 - 10;
    }
}