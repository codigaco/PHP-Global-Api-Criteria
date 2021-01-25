<?php

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;

function getEntityManager(): EntityManager
{
    $connection = [
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/../database/database.sqlite',
    ];

    $contextDir = __DIR__ . '/../../..';

    $configuration = new Configuration();

    $driver = new SimplifiedXmlDriver([
        $contextDir . "/ProductModule/Infrastructure/ORM/Product" => 'QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model'
    ]);

    $configuration->setMetadataDriverImpl($driver);
    $configuration->setProxyDir(sys_get_temp_dir());
    $configuration->setProxyNamespace('Proxies');

    return EntityManager::create($connection, $configuration);
}
