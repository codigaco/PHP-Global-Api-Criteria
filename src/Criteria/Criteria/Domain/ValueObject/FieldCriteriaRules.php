<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\Exception\FieldCriteriaRuleViolationException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\Exception\InvalidFieldCriteriaRuleForAssertFieldException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\ComparisonOperator;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\Order;
use QuiqueGilB\GlobalApiCriteria\Shared\Field\Domain\ValueObject\Field;
use RuntimeException;

class FieldCriteriaRules
{
    private $field;
    private $sortable;
    private $filterable;
    private $comparisonOperators;

    public function __construct(Field $field)
    {
        $this->field = $field;
        $this->comparisonOperators = [];
        $this->sortable = true;
        $this->filterable = true;
    }

    public static function create(string $field): self
    {
        return new static(new Field($field));
    }

    public function sortable(bool $isSortable): self
    {
        $this->sortable = $isSortable;
        return $this;
    }

    public function filterable(bool $isFilterable): self
    {
        $this->filterable = $isFilterable;
        return $this;
    }

    public function comparisonOperators(ComparisonOperator ...$comparisonOperators): self
    {
        $this->comparisonOperators = $comparisonOperators;
        return $this;
    }

    public function field(): Field
    {
        return $this->field;
    }

    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    private function assertRuleForField(Field $field): void
    {
        if (!$this->field->equals($field)) {
            throw new InvalidFieldCriteriaRuleForAssertFieldException(
                'Invalid rule ' . $this->field->value() . ' for ' . $field->value()
            );
        }
    }

    public function assertFilter(Filter $filter): void
    {
        $this->assertRuleForField($filter->field());

        if (false === $this->isFilterable()) {
            throw new FieldCriteriaRuleViolationException($filter->serialize());
        }

        if (empty($this->comparisonOperators)) {
            return;
        }

        foreach ($this->comparisonOperators as $comparisonOperator) {
            if ($filter->operator()->equals($comparisonOperator)) {
                return;
            }
        }

        throw new FieldCriteriaRuleViolationException($filter->serialize());
    }

    public function assertOrder(Order $order): void
    {
        $this->assertRuleForField($order->field());
        if (false === $this->isSortable()) {
            throw new FieldCriteriaRuleViolationException($order->serialize());
        }
    }
}
