<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject\Field;
use QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject\Value;

class Filter extends BaseFilter
{
    private $field;
    private $operator;
    private $value;

    public function __construct(Field $field, ComparisonOperator $operator, Value $value)
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

    public function value(): Value
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

        return new static(
            new Field($field),
            new ComparisonOperator($operator),
            Value::deserialize($value)
        );
    }

    public function serialize(): string
    {
        return $this->field->value() . ' ' . $this->operator->value() . ' ' . $this->value->serialize();
    }
}
