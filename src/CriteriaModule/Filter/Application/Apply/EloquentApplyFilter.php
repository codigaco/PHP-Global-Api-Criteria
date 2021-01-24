<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Application\Apply;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\ComparisonOperator;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\FilterGroup;
use TypeError;

class EloquentApplyFilter
{
    /**
     * @param Builder|\Illuminate\Database\Query\Builder$builder
     * @param $filter
     * @param array $mapFields
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public static function apply($builder, $filter, $mapFields = [])
    {
        if (!$builder instanceof Builder && !$builder instanceof \Illuminate\Database\Query\Builder) {
            throw new TypeError(gettype($builder));
        }
        if (is_null($filter)) {
            return $builder;
        }
        if ($filter instanceof FilterGroup) {
            foreach ($filter->filters() as $filterItem) {
                $createBuilder = static function ($subBuilder) use ($filterItem, $mapFields) {
                    return static::apply($subBuilder, $filterItem, $mapFields);
                };

                $builder = $filterItem->logicalOperator()->isAnd()
                    ? $builder->where($createBuilder)
                    : $builder->orWhere($createBuilder);
            }
            return $builder;
        }

        if (!$filter instanceof Filter) {
            throw new TypeError(get_class($filter));
        }

        $mapped = $mapFields[$filter->field()->value()] ?? $filter->field()->value();
        $builder->where(
            $mapped,
            self::operator($filter->operator()),
            $filter->value()->scalar(),
            $filter->logicalOperator()->isAnd() ? 'AND' : 'OR'
        );
        return $builder;
    }

    private static function operator(ComparisonOperator $operator): string
    {
        if ($operator->isEqual()) {
            return '=';
        }

        if ($operator->isNotEqual()) {
            return '!=';
        }

        if ($operator->isGreater()) {
            return '>';
        }

        if ($operator->isGreaterOrEqual()) {
            return '>=';
        }

        if ($operator->isLess()) {
            return '<';
        }
        if ($operator->isLessOrEqual()) {
            return '<=';
        }
        if ($operator->isIn()) {
            return 'IN';
        }
        if ($operator->isLike()) {
            return 'LIKE';
        }

        return '=';
    }
}
