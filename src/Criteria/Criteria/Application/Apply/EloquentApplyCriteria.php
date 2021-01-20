<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Application\Apply;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Application\Apply\EloquentApplyFilter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Application\Apply\EloquentApplyOrder;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Application\Apply\EloquentApplyPaginate;

class EloquentApplyCriteria
{
    public static function apply(Builder $builder, Criteria $criteria, array $mapFields = []): Builder
    {
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
