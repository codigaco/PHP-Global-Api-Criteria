<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Application\Apply;

use Doctrine\ORM\QueryBuilder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Domain\ValueObject\OrderGroup;
use TypeError;

class DoctrineApplyOrder
{
    /**
     * @param QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $builder
     * @param OrderGroup $orderGroup
     * @param array $mapFields
     * @return QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder
     */
    public static function apply($builder, OrderGroup $orderGroup, array $mapFields = [])
    {
        if (!$builder instanceof QueryBuilder && !$builder instanceof \Doctrine\DBAL\Query\QueryBuilder) {
            throw new TypeError(gettype($builder));
        }

        foreach ($orderGroup->orders() as $order) {
            $mapped = $mapFields[$order->field()->value()] ?? $order->field()->value();
            $builder->orderBy($mapped, $order->type()->isAsc() ? 'ASC' : 'DESC');
        }
        return $builder;
    }
}
