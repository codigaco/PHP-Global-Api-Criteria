<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\ComparisonOperator;
use QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject\Field;

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

}
