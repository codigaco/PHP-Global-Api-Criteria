<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Model;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;

interface CategoryRepository
{
    public function querySearch(Criteria $criteria): array;

    public function queryCount(Criteria $criteria): int;
}
