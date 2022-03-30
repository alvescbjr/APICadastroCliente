<?php

namespace Alvescbjr\ApiCadastroCliente\interfaces;

interface ControleDeSolicitacoesAPI
{
    public function findBy(int $page)            : array;
    public function findOneBy(int $id)           : array;
    public function insert(array $data)          : array;
    public function update(int $id, array $data) : array;
    public function remove(int $id)              : array;
}