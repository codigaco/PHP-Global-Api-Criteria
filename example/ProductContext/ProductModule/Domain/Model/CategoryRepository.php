<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;

interface CategoryRepository
{
    public function querySearch(Criteria $criteria): array;

    public function queryCount(Criteria $criteria): int;
}
