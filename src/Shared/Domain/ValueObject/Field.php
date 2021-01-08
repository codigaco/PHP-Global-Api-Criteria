<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Shared\Domain\Exception\InvalidFieldException;

class Field
{
    private $value;

    public function __construct(string $field)
    {
        self::validate($field);
        $this->value = $field;
    }

    public function value(): string
    {
        return $this->value;
    }

    private static function validate(string $field): void
    {
        if (empty($field)) {
            throw new InvalidFieldException($field);
        }
    }

    public function has(string $field): bool
    {
        return 0 === strpos($this->value . '.', $field . '.');
    }

}
