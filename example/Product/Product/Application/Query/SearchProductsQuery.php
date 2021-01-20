<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Application\Query;

use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Criteria\ProductCriteriaExample;

class SearchProductsQuery
{
    private $productCriteriaExample;

    public function __construct(ProductCriteriaExample $productCriteriaExample)
    {
        $this->productCriteriaExample = $productCriteriaExample;
    }

    public function criteria(): ProductCriteriaExample
    {
        return $this->productCriteriaExample;
    }
}
