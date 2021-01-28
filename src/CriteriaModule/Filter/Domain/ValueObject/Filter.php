<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\SharedModule\Field\Domain\ValueObject\Field;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Value\Domain\ValueObject\Value;

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

    public function hasField(string $field): bool
    {
        return $this->field->has($field);
    }

    public static function deserialize($filterExpression): self
    {
        $operatorRegex = ComparisonOperator::regex();

        [$field, $value] = preg_split($operatorRegex, $filterExpression);
        preg_match($operatorRegex, $filterExpression, $operators);

        return new static(
            new Field($field),
            new ComparisonOperator($operators[0] ?? ''),
            Value::deserialize(trim($value))
        );
    }

    public function serialize(): string
    {
        return $this->field->value() . ' ' . $this->operator->value() . ' ' . $this->value->serialize();
    }
}
