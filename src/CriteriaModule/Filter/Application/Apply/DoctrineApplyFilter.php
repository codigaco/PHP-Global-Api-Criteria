<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Application\Apply;

use Doctrine\ORM\QueryBuilder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\Exception\InvalidComparisonOperatorException;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\FilterGroup;
use TypeError;

class DoctrineApplyFilter
{
    private static $iValue = 0;

    /**
     * @param QueryBuilder $builder
     * @param FilterGroup | Filter | null $filter
     * @param array $mapFields
     * @return QueryBuilder
     */
    public static function apply(QueryBuilder $builder, $filter, array $mapFields = []): QueryBuilder
    {
        if (is_null($filter)) {
            return $builder;
        }

        $expr = self::createExpr($builder, $filter, $mapFields);
        $builder->andWhere($expr);

        return $builder;
    }

    private static function createExpr(QueryBuilder $builder, $filter, array $mapFields)
    {
        if (!$filter instanceof Filter && !$filter instanceof FilterGroup) {
            throw new TypeError(get_class($filter));
        }

        if ($filter instanceof FilterGroup) {
            return self::createGroupExpr($builder, $filter, $mapFields);
        }

        return self::createComparisonExpr($builder, $filter, $mapFields);
    }

    private static function createGroupExpr(QueryBuilder $builder, FilterGroup $filterGroup, array $mapFields)
    {
        $logical = $filterGroup->logicalOperator();
        $expr = $logical->isAnd() ? $builder->expr()->andX() : $builder->expr()->orX();

        foreach ($filterGroup->filters() as $filter) {
            $expression = self::createExpr($builder, $filter, $mapFields);

            if (!$logical->equals($filter->logicalOperator())) {
                $logical = $filter->logicalOperator();
                $expr = $logical->isAnd()
                    ? $builder->expr()->andX($expr)
                    : $builder->expr()->orX($expr);
            }

            $expr->add($expression);
        }

        return $expr;
    }

    private static function createComparisonExpr(QueryBuilder $builder, Filter $filter, array $mapFields)
    {
        $mapped = $mapFields[$filter->field()->value()] ?? $filter->field()->value();

        if ($filter->value()->type()->isNull()) {
            return $filter->operator()->isEqual()
                ? $builder->expr()->isNull($mapped)
                : $builder->expr()->isNotNull($mapped);
        }

        $valueAlias = self::createValueAlias();
        $builder->setParameter($valueAlias, $filter->value()->scalar());

        $valueAlias = ':' . $valueAlias;

        if ($filter->operator()->isEqual()) {
            return $builder->expr()->eq($mapped, $valueAlias);
        }
        if ($filter->operator()->isNotEqual()) {
            return $builder->expr()->neq($mapped, $valueAlias);
        }
        if ($filter->operator()->isGreater()) {
            return $builder->expr()->gt($mapped, $valueAlias);
        }
        if ($filter->operator()->isGreaterOrEqual()) {
            return $builder->expr()->gte($mapped, $valueAlias);
        }
        if ($filter->operator()->isLess()) {
            return $builder->expr()->lt($mapped, $valueAlias);
        }
        if ($filter->operator()->isLessOrEqual()) {
            return $builder->expr()->lte($mapped, $valueAlias);
        }
        if ($filter->operator()->isIn()) {
            return $builder->expr()->in($mapped, $valueAlias);
        }
        if ($filter->operator()->isLike()) {
            return $builder->expr()->like($mapped, $valueAlias);
        }

        throw new InvalidComparisonOperatorException($filter->operator()->value());
    }

    private static function createValueAlias(): string
    {
        return 'value' . ++self::$iValue;
    }
}
