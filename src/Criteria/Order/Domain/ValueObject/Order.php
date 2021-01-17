<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Shared\Field\Domain\ValueObject\Field;

class Order
{
    private $field;
    private $orderType;

    public function __construct(Field $field, OrderType $orderType = null)
    {
        $this->field = $field;
        $this->orderType = $orderType ?? new OrderType('');
    }

    public function field(): Field
    {
        return $this->field;
    }

    public function type(): OrderType
    {
        return $this->orderType;
    }

    public function hasField(string $field): bool
    {
        return $this->field->has($field);
    }

    public static function deserialize(string $order): self
    {
        $order = trim($order);
        $firstChart = $order[0];

        if ('-' === $firstChart || '+' === $firstChart) {
            return new static(
                new Field(substr($order, 1)),
                new OrderType($firstChart)
            );
        }

        $orderParts = explode(' ', $order);
        return new static(
            new Field($orderParts[0]),
            new OrderType($orderParts[1] ?? '')
        );
    }

    public function serialize(): string
    {
        if ('' === $this->orderType->value()) {
            return $this->field->value();
        }

        return 1 === strlen($this->orderType->value())
            ? $this->orderType->value() . $this->field->value()
            : $this->field->value() . ' ' . $this->orderType->value();
    }
}
