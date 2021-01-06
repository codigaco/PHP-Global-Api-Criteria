<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Shared\Shared\Domain\ValueObject\Field;

class Filter
{
    private $field;
    private $operator;
    private $value;

    public function __construct(Field $field, ComparisonOperator $operator, $value)
    {
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function field(): Field
    {
        return $this->field;
    }

    public function operator(): ComparisonOperator
    {
        return $this->operator;
    }

    public function value()
    {
        return $this->value;
    }

}
