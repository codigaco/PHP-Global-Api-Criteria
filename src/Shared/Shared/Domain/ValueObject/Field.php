<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Shared\Domain\ValueObject;

class Field
{
    private $value;

    public function __construct(string $field)
    {
        $this->value = $field;
    }

    public function value(): string
    {
        return $this->value;
    }
}
