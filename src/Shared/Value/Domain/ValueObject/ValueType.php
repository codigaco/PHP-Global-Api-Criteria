<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Value\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Shared\Value\Domain\Exception\InvalidValueTypeException;
use QuiqueGilB\GlobalApiCriteria\Shared\Utils\Domain\Helper\StringHelper;

class ValueType
{
    private const TYPE_STRING = 'string';
    private const TYPE_INT = 'int';
    private const TYPE_DECIMAL = 'decimal';
    private const TYPE_ARRAY = 'array';
    private const TYPE_NULL = 'null';
    private const TYPE_BOOLEAN = 'boolean';

    private $value;

    public function __construct(string $type)
    {
        self::validate($type);
        $this->value = $type;
    }

    public static function acceptedValues(): array
    {
        return [
            self::TYPE_STRING,
            self::TYPE_INT,
            self::TYPE_DECIMAL,
            self::TYPE_ARRAY,
            self::TYPE_NULL,
            self::TYPE_BOOLEAN
        ];
    }

    private static function validate(string $type): void
    {
        if (!in_array($type, self::acceptedValues())) {
            throw new InvalidValueTypeException($type);
        }
    }

    public function isString(): bool
    {
        return $this->value === self::TYPE_STRING;
    }

    public function isInt(): bool
    {
        return $this->value === self::TYPE_INT;
    }

    public function isDecimal(): bool
    {
        return $this->value === self::TYPE_DECIMAL;
    }

    public function isNumber(): bool
    {
        return $this->isInt() || $this->isDecimal();
    }

    public function isArray(): bool
    {
        return $this->value === self::TYPE_ARRAY;
    }

    public function isNull(): bool
    {
        return $this->value === self::TYPE_NULL;
    }

    public function isBoolean(): bool
    {
        return $this->value === self::TYPE_BOOLEAN;
    }


    public static function fromValue(string $value): self
    {
        if ('null' === $value) {
            return new static(self::TYPE_NULL);
        }

        if (is_numeric($value)) {
            if (strpos($value, '.')) {
                return new static(self::TYPE_DECIMAL);
            }
            return new static(self::TYPE_INT);
        }

        if ('false' === $value || 'true' === $value) {
            return new static(self::TYPE_BOOLEAN);
        }

        $parts = StringHelper::split($value);
        if (1 < count($parts)) {
            return new static(self::TYPE_ARRAY);
        }

        return new static(self::TYPE_STRING);
    }
}
