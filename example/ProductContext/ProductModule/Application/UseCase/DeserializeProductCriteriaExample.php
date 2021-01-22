<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Application\UseCase;

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;

class DeserializeProductCriteriaExample
{
    public function __invoke()
    {
        $productCriteria = ProductCriteriaExample::create()
            ->withFilter(FilterGroup::deserialize('(name like computer or name like pc) and price > 500 and price <= 1000'))
            ->withOrder(OrderGroup::deserialize('price asc, stock desc'))
            ->withPaginate(Paginate::create(0, 5));
    }

}
