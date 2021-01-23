<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Application\Query\Product;

use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;

class SearchProductByIdQuery
{

    private $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    public function productId(): int
    {
        return $this->productId;
    }
}
