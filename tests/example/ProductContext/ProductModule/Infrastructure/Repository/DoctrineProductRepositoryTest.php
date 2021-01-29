<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Tests\ProductContext\ProductModule\Infrastructure\Repository;

use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\Product;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository\DoctrineProductRepository;

class DoctrineProductRepositoryTest extends ProductRepositoryTest
{
    protected function setUp(): void
    {
        require_once __DIR__ . '/../../../../../../example/ProductContext/SharedModule/Infrastructure/Doctrine/configuration.php';

        $this->productRepository = new DoctrineProductRepository(
            getEntityManager(),
            getEntityManager()->getClassMetadata(Product::class)
        );
    }
}
