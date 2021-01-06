<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Order\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Shared\Shared\Domain\ValueObject\Field;

class Order
{
    private $field;
    private $orderType;

    public function __construct(Field $field, OrderType $orderType)
    {
        $this->field = $field;
        $this->orderType = $orderType;
    }

    public function field(): Field
    {
        return $this->field;
    }

    public function orderType(): OrderType
    {
        return $this->orderType;
    }
}
