<?php

namespace QuiqueGilB\GlobalApiCriteria\SharedModule\Field\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\SharedModule\Field\Domain\Exception\InvalidFieldException;

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
        if (empty($field) || false !== strpos($field, ' ')) {
            throw new InvalidFieldException($field);
        }
    }

    public function has(string $field): bool
    {
        $shortField = strlen($field) < strlen($this->value) ? $field : $this->value;
        $longField = $shortField === $field ? $this->value : $field;

        return 0 === strpos($longField . '.', $shortField . '.');
    }

    public function equals(?Field $field): bool
    {
        return null !== $field && $field->value() === $this->value();
    }
}
