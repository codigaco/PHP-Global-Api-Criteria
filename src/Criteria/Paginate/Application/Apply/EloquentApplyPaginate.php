<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Application\Apply;

use Illuminate\Database\Query\Builder;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;

class EloquentApplyPaginate
{
    public static function apply(Builder $builder, Paginate $paginate): Builder
    {
        $builder->offset($paginate->offset()->value());
        $builder->limit($paginate->limit()->value());

        return $builder;
    }
}
