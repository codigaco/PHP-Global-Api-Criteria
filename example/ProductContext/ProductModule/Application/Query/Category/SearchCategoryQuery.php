<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Application\Query\Category;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;

class SearchCategoryQuery
{
    private $criteria;

    public function __construct(Criteria $criteria)
    {
        $this->criteria = $criteria;
    }

    public function criteria(): Criteria
    {
        return $this->criteria;
    }
}
