<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Application\Apply;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject\Paginate;
use TypeError;

class EloquentApplyPaginate
{
    /**
     * @param $builder
     * @param Paginate $paginate
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public static function apply($builder, Paginate $paginate)
    {
        if (!$builder instanceof Builder && !$builder instanceof \Illuminate\Database\Query\Builder) {
            throw new TypeError(gettype($builder));
        }

        if (false === $paginate->offset()->isZero()) {
            $builder->offset($paginate->offset()->value());
        }

        if (false === $paginate->limit()->isZero()) {
            $builder->limit($paginate->limit()->value());
        }
        return $builder;
    }
}
