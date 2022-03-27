<?php

namespace Alvescbjr\API\helpers;

final class UtilsAPI
{
    public static function removerIndiceComValorVazio(array $array) : array
    {
        $novoArray = [];

        array_walk($array,function(mixed $value) use (&$novoArray){
            if (empty($value) === false) {
                $novoArray[] = $value;
            }
        });

        return $novoArray;
    }
}