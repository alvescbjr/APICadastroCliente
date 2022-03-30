<?php

require_once __DIR__ . "/vendor/autoload.php";

use Alvescbjr\ApiCadastroCliente\helpers\EntityManagerFactory;

try {
    $entityManager = (new EntityManagerFactory())->getEntityManager();

    echo '<pre>';
        var_dump($entityManager->getConnection());
    echo '</pre>';

} catch (\Exception $e) {
    print_r($e->getMessage());
}