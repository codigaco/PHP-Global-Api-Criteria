<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria;

use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\FieldCriteriaRules;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\ComparisonOperator;

/** @method static create(): ProductCriteriaExample */
class ProductCriteriaExample extends Criteria
{
    protected static function createRules(): array
    {
        return [
            FieldCriteriaRules::create('id')
                ->sortable(false)
                ->comparisonOperators(
                    ComparisonOperator::equal(),
                    ComparisonOperator::in()
                ),
            FieldCriteriaRules::create('name')
                ->comparisonOperators(
                    ComparisonOperator::equal(),
                    ComparisonOperator::like(),
                ),
            FieldCriteriaRules::create('stock')
                ->comparisonOperators(
                    ComparisonOperator::greater(),
                    ComparisonOperator::greaterOrEqual(),
                    ComparisonOperator::less(),
                    ComparisonOperator::lessOrEqual()
                ),
            FieldCriteriaRules::create('price'),
            FieldCriteriaRules::create('count_sales'),
            FieldCriteriaRules::create('category.id')
                ->sortable(false)
                ->comparisonOperators(
                    ComparisonOperator::equal(),
                    ComparisonOperator::in()
                ),
            FieldCriteriaRules::create('category.name')
                ->sortable(false)
                ->comparisonOperators(
                    ComparisonOperator::equal(),
                    ComparisonOperator::in(),
                    ComparisonOperator::like(),
                ),

        ];
    }
}