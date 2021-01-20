<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Model;

use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Criteria\ProductCriteriaExample;

interface ProductRepository
{
    public function querySearch(ProductCriteriaExample $productCriteria): array;

    public function queryCount(ProductCriteriaExample $productCriteria): int;
}
