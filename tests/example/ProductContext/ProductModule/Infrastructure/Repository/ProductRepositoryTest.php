<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Tests\ProductContext\ProductModule\Infrastructure\Repository;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject\Paginate;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\ProductRepository;

abstract class ProductRepositoryTest extends TestCase
{
    /** @var ProductRepository */
    protected $productRepository;

    /**
     * @group filter
     * @test
     */
    public function assert_query_search_by_criteria_equal_filter(): void
    {
        $criteria = ProductCriteriaExample::create()
            ->withFilter('price = 300');

        $products = $this->productRepository->querySearch($criteria);

        self::assertCount(2, $products);
    }

    /**
     * @group filter
     * @test
     */
    public function assert_query_count_by_criteria_equal_filter(): void
    {
        $criteria = ProductCriteriaExample::create()
            ->withFilter('price = 300');

        $countProducts = $this->productRepository->queryCount($criteria);

        self::assertEquals(2, $countProducts);
    }

    /**
     * @group filter
     * @test
     */
    public function assert_query_search_by_criteria_not_equal_filter(): void
    {
        $criteria = ProductCriteriaExample::create()
            ->withFilter('price != 300');

        $products = $this->productRepository->querySearch($criteria);

        self::assertCount(26, $products);
    }

    /**
     * @group paginate
     * @test
     */
    public function assert_query_search_by_criteria_paginate_limit(): void
    {
        $criteria = ProductCriteriaExample::create()
            ->withPaginate(Paginate::create(0, 5));

        $products = $this->productRepository->querySearch($criteria);

        self::assertCount(5, $products);
    }

    /**
     * @group paginate
     * @test
     */
    public function assert_query_count_by_criteria_paginate_limit(): void
    {
        $criteria = ProductCriteriaExample::create()
            ->withPaginate(Paginate::create(0, 5));

        $countProducts = $this->productRepository->queryCount($criteria);

        self::assertEquals(28, $countProducts);
    }
}
