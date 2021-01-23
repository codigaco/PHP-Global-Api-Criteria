<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Application\Query\Product;

use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;

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
