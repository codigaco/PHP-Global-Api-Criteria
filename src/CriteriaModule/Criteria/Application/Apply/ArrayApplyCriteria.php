<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Application\Apply;

use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Application\Apply\ArrayApplyFilter;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Application\Apply\ArrayApplyOrder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Application\Apply\ArrayApplyPaginate;

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
