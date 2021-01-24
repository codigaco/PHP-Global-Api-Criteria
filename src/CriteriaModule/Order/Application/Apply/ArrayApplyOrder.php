<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Application\Apply;

use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Utils\Domain\Helper\Obj;

class ArrayApplyOrder
{
    public static function apply(array $array, OrderGroup $orderGroup, array $mapFields = []): array
    {
        usort($array,
            static function ($a, $b) use ($orderGroup, $mapFields) {
                foreach ($orderGroup->orders() as $order) {
                    $mapped = $mapFields[$order->field()->value()] ?? $order->field()->value();

                    $valueA = is_callable($mapped) ? $mapped($a) : Obj::get($a, $mapped);
                    $valueB = is_callable($mapped) ? $mapped($b) : Obj::get($b, $mapped);
                    $response = $valueA <=> $valueB;

                    if ($response !== 0) {
                        return $response * ($order->type()->isDesc() ? -1 : 1);
                    }
                }
                return 0;
            });

        return array_values($array);
    }

}
