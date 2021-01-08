<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Shared\Domain\Helper\StringHelper;

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
        $this->value = $type;
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
            return new self(self::TYPE_NULL);
        }

        if (is_numeric($value)) {
            if (strpos($value, '.')) {
                return new self(self::TYPE_DECIMAL);
            }
            return new self(self::TYPE_INT);
        }

        if ('false' === $value || 'true' === $value) {
            return new self(self::TYPE_BOOLEAN);
        }

        $parts = StringHelper::split($value);
        if (1 < count($parts)) {
            return new self(self::TYPE_ARRAY);
        }

        return new self(self::TYPE_STRING);
    }
}
