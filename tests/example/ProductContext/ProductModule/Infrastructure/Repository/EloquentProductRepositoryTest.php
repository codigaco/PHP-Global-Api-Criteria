<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Tests\ProductContext\ProductModule\Infrastructure\Repository;

use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\Product;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository\DoctrineProductRepository;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository\EloquentProductRepository;

class EloquentProductRepositoryTest extends ProductRepositoryTest
{
    protected function setUp(): void
    {
        require_once __DIR__ . '/../../../../../../example/ProductContext/SharedModule/Infrastructure/Eloquent/configuration.php';
        $this->productRepository = new EloquentProductRepository();
    }
}
