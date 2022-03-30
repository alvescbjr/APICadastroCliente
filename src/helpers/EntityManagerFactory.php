<?php

namespace Alvescbjr\ApiCadastroCliente\helpers;

use Doctrine\ORM\{EntityManager, EntityManagerInterface};
use Doctrine\ORM\Tools\Setup;


class EntityManagerFactory
{
    /**
     * @return EntityManagerInterface
     * @throws \Doctrine\ORM\ORMException
     */
    public function getEntityManager() : EntityManagerInterface
    {
        $rootDir = __DIR__ . "/../..";
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(
            [$rootDir . '/src'],
            $isDevMode,
            $proxyDir,
            $cache, 
            $useSimpleAnnotationReader,
        );

        // $connection = [
        //     'driver'    => 'pdo_mysql',
        //     'host'      => 'localhost',
        //     'dbname'    => 'economy',
        //     'user'      => 'root',
        //     'password'  => ''
        // ];

          $connection = [
            "driver" => "pdo_sqlite",
            "path"  => "{$rootDir}/var/data/cliente.sqlite"
        ];

        return EntityManager::create($connection, $config);
    }
}