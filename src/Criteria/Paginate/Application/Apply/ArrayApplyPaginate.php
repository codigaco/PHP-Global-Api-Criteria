<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Application\Apply;

use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;

class ArrayApplyPaginate
{
    public static function apply(array $array, Paginate $paginate): array
    {
        return array_values(array_slice($array, $paginate->offset()->value(), $paginate->limit()->value()));
    }
}
