<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Application\Apply;

use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject\Paginate;

class ArrayApplyPaginate
{
    public static function apply(array $array, Paginate $paginate): array
    {
        return array_values(array_slice($array, $paginate->offset()->value(), $paginate->limit()->value()));
    }
}
