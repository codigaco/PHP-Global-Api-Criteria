<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Application\Apply;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Application\Apply\ArrayApplyFilter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Application\Apply\ArrayApplyOrder;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Application\Apply\ArrayApplyPaginate;

class ArrayApplyCriteria
{
    public static function apply(array $array, Criteria $criteria, array $mapFields = []): array
    {
        $array = ArrayApplyFilter::apply($array, $criteria->filters(), $mapFields);
        $array = ArrayApplyOrder::apply($array, $criteria->orders(), $mapFields);
        $array = ArrayApplyPaginate::apply($array, $criteria->paginate());
        return $array;
    }
}
