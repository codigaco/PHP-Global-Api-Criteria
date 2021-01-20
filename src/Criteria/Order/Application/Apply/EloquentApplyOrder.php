<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Order\Application\Apply;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;

class EloquentApplyOrder
{
    public static function apply(Builder $builder, OrderGroup $orderGroup, array $mapFields = []): Builder
    {
        foreach ($orderGroup->orders() as $order) {
            $mapped = $mapFields[$order->field()->value()] ?? $order->field()->value();
            $builder->orderBy($mapped, $order->type()->isAsc() ? 'ASC' : 'DESC');
        }
        return $builder;
    }
}
