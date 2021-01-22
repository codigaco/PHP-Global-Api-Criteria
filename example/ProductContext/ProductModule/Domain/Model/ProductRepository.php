<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model;

use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;

interface ProductRepository
{
    public function querySearch(ProductCriteriaExample $productCriteria): array;

    public function queryCount(ProductCriteriaExample $productCriteria): int;
}
