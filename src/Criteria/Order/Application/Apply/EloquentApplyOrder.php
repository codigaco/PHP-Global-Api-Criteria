<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Order\Application\Apply;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;

class EloquentApplyOrder
{
    /**
     * @param Builder|\Illuminate\Database\Query\Builder $builder
     * @param OrderGroup $orderGroup
     * @param array $mapFields
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public static function apply($builder, OrderGroup $orderGroup, array $mapFields = [])
    {
        if (!$builder instanceof Builder && !$builder instanceof \Illuminate\Database\Query\Builder) {
            throw new \TypeError(gettype($builder));
        }

        foreach ($orderGroup->orders() as $order) {
            $mapped = $mapFields[$order->field()->value()] ?? $order->field()->value();
            $builder->orderBy($mapped, $order->type()->isAsc() ? 'ASC' : 'DESC');
        }
        return $builder;
    }
}
