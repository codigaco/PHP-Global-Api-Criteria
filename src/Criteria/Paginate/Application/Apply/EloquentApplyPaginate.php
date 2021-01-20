<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Application\Apply;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;

class EloquentApplyPaginate
{
    public static function apply(Builder $builder, Paginate $paginate): Builder
    {
        if (false === $paginate->offset()->isZero()) {
            $builder->offset($paginate->offset()->value());
        }

        if (false === $paginate->limit()->isZero()) {
            $builder->limit($paginate->limit()->value());
        }
        return $builder;
    }
}
