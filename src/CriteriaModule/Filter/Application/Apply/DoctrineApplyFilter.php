<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Application\Apply;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\QueryBuilder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\ComparisonOperator;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\LogicalOperator;
use TypeError;

class DoctrineApplyFilter
{
    private static $iValue = 0;

    /**
     * @param QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $builder
     * @param FilterGroup | Filter | null $filter
     * @param array $mapFields
     * @return QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder
     */
    public static function apply($builder, $filter, $mapFields = [])
    {
        if (!$builder instanceof QueryBuilder && !$builder instanceof \Doctrine\DBAL\Query\QueryBuilder) {
            throw new TypeError(gettype($builder));
        }

        if (is_null($filter)) {
            return $builder;
        }

        $expr = self::createExpr($builder, $filter, $mapFields);
        $builder->where($expr);
        dd($builder->getDQL());
        return $builder;
    }

    /**
     * @param QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $builder
     * @param FilterGroup | Filter $filter
     * @param array $mapFields
     * @return CompositeExpression|Expr\Andx|Comparison|string
     */
    private static function createExpr($builder, $filter, array $mapFields)
    {
        if (!$filter instanceof Filter && !$filter instanceof FilterGroup) {
            throw new TypeError(get_class($filter));
        }

        if ($filter instanceof FilterGroup) {
            $logical = $filter->logicalOperator();
            $expr = $logical->isAnd() ? $builder->expr()->andX() : $builder->expr()->orX();

            foreach ($filter->filters() as $filterItem) {
                $expression = self::createExpr($builder, $filterItem, $mapFields);

                if (!$logical->equals($filterItem->logicalOperator())) {
                    $logical = $filterItem->logicalOperator();
                    $expr = $logical->isAnd()
                        ? $builder->expr()->andX($expr)
                        : $builder->expr()->orX($expr);
                }

                $expr->add($expression);
            }

            return $expr;
        }

        $valueAlias = self::getValueAlias();
        $mapped = $mapFields[$filter->field()->value()] ?? $filter->field()->value();
        $comparisonExpr = new Comparison($mapped, self::operator($filter->operator()), ":$valueAlias");

        $builder->setParameter($valueAlias, $filter->value()->scalar());
        return $comparisonExpr;
    }

    private static function getValueAlias(): string
    {
        return 'value' . ++self::$iValue;
    }

    private static function operator(ComparisonOperator $operator): string
    {
        if ($operator->isEqual()) {
            return Comparison::EQ;
        }

        if ($operator->isNotEqual()) {
            return Comparison::NEQ;
        }

        if ($operator->isGreater()) {
            return Comparison::GT;
        }

        if ($operator->isGreaterOrEqual()) {
            return Comparison::GTE;
        }

        if ($operator->isLess()) {
            return Comparison::LT;
        }
        if ($operator->isLessOrEqual()) {
            return Comparison::LTE;
        }

        throw new \RuntimeException('Operator not implemented');
        if ($operator->isIn()) {
        }
        if ($operator->isLike()) {
        }

        return '=';
    }
}
