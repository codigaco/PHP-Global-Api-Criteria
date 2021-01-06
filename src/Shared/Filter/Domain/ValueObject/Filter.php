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

    public static function deserialize($filterExpression): self
    {
        $firstSpace = strpos($filterExpression, ' ');
        $field = substr($filterExpression, 0, $firstSpace);

        $secondSpace = strpos($filterExpression, ' ', $firstSpace + 1);
        $operator = substr($filterExpression, $firstSpace + 1, $secondSpace - $firstSpace - 1);

        $value = substr($filterExpression, $secondSpace + 1);

        return new static(new Field($field), new ComparisonOperator($operator), $value);
    }

}
