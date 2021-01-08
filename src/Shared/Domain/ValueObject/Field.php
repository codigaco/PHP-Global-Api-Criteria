<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Shared\Domain\Exception\InvalidFieldException;

class Field
{
    private $value;

    /**
     * Field constructor.
     * @param string $field
     * @throws InvalidFieldException
     */
    public function __construct(string $field)
    {
        self::validate($field);
        $this->value = $field;
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param string $field
     * @throws InvalidFieldException
     */
    private static function validate(string $field): void
    {
        if (empty($field) || false !== strpos($field, ' ')) {
            throw new InvalidFieldException($field);
        }
    }

    public function has(string $field): bool
    {
        return 0 === strpos($this->value . '.', $field . '.');
    }
}
