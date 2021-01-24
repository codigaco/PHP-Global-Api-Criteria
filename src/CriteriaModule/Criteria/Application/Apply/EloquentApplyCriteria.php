<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Application\Apply;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Application\Apply\EloquentApplyFilter;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Application\Apply\EloquentApplyOrder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Application\Apply\EloquentApplyPaginate;
use TypeError;

class EloquentApplyCriteria
{
    /**
     * @param $builder
     * @param Criteria $criteria
     * @param array $mapFields
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public static function apply($builder, Criteria $criteria, array $mapFields = [])
    {
        if (!$builder instanceof Builder && !$builder instanceof \Illuminate\Database\Query\Builder) {
            throw new TypeError(gettype($builder));
        }

        if (null !== $criteria->filters()) {
            $builder = EloquentApplyFilter::apply($builder, $criteria->filters(), $mapFields);
        }

        if (null !== $criteria->orders()) {
            $builder = EloquentApplyOrder::apply($builder, $criteria->orders(), $mapFields);
        }

        if (null !== $criteria->paginate()) {
            $builder = EloquentApplyPaginate::apply($builder, $criteria->paginate());
        }
        return $builder;
    }
}
