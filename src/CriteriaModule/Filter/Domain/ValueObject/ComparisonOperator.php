<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\Exception\InvalidComparisonOperatorException;

class ComparisonOperator
{
    private const EQUAL = 'eq';
    private const NOT_EQUAL = 'ne';
    private const GREATER = 'gt';
    private const GREATER_OR_EQUAL = 'ge';
    private const LESS = 'lt';
    private const LESS_OR_EQUAL = 'le';
    private const IN = 'in';
    private const NOT_IN = "not in";
    private const LIKE = 'like';
    private const NOT_LIKE = 'not like';

    private const MAP = [
        "=" => self::EQUAL,
        "eq" => self::EQUAL,
        "is" => self::EQUAL,

        "!=" => self::NOT_EQUAL,
        "<>" => self::NOT_EQUAL,
        "ne" => self::NOT_EQUAL,
        "is not" => self::NOT_EQUAL,

        "gt" => self::GREATER,
        ">" => self::GREATER,

        ">=" => self::GREATER_OR_EQUAL,
        "ge" => self::GREATER_OR_EQUAL,
        "gte" => self::GREATER_OR_EQUAL,

        "<" => self::LESS,
        "lt" => self::LESS,

        "=<" => self::LESS_OR_EQUAL,
        "le" => self::LESS_OR_EQUAL,
        "lte" => self::LESS_OR_EQUAL,

        "in" => self::IN,
        "not in" => self::NOT_IN,

        "like" => self::LIKE,
        "not like" => self::NOT_LIKE,

        "contains" => self::LIKE
    ];

    private $value;

    public function __construct(string $operator)
    {
        $operator = strtolower(trim($operator));

        self::validate($operator);
        $this->value = $operator;
    }

    public static function validate(string $operator): void
    {
        if (!array_key_exists($operator, self::MAP)) {
            throw new InvalidComparisonOperatorException($operator);
        }
    }

    public static function create(string $operator): self
    {
        return new static($operator);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function type(): string
    {
        return static::MAP[$this->value];
    }

    public function equals(?ComparisonOperator $comparisonOperator, bool $strict = false): bool
    {
        if (null === $comparisonOperator) {
            return false;
        }

        return true === $strict
            ? $this->value() === $comparisonOperator->value()
            : $this->type() === $comparisonOperator->type();
    }

    public function isEqual(): bool
    {
        return $this->type() === self::EQUAL;
    }

    public function isNotEqual(): bool
    {
        return $this->type() === self::NOT_EQUAL;
    }

    public function isGreater(): bool
    {
        return $this->type() === self::GREATER;
    }

    public function isGreaterOrEqual(): bool
    {
        return $this->type() === self::GREATER_OR_EQUAL;
    }

    public function isLess(): bool
    {
        return $this->type() === self::LESS;
    }

    public function isLessOrEqual(): bool
    {
        return $this->type() === self::LESS_OR_EQUAL;
    }

    public function isIn(): bool
    {
        return $this->type() === self::IN;
    }

    public function isNotIn(): bool
    {
        return $this->type() === self::NOT_IN;
    }

    public function isLike(): bool
    {
        return $this->type() === self::LIKE;
    }

    public function isNotLike(): bool
    {
        return $this->type() === self::NOT_LIKE;
    }

    public static function equal(): self
    {
        return new static(self::EQUAL);
    }

    public static function notEqual(): self
    {
        return new static(self::NOT_EQUAL);
    }

    public static function greater(): self
    {
        return new static(self::GREATER);
    }

    public static function greaterOrEqual(): self
    {
        return new static(self::GREATER_OR_EQUAL);
    }

    public static function less(): self
    {
        return new static(self::LESS);
    }

    public static function lessOrEqual(): self
    {
        return new static(self::LESS_OR_EQUAL);
    }

    public static function in(): self
    {
        return new static(self::IN);
    }

    public static function like(): self
    {
        return new static(self::LIKE);
    }

    public static function regex(): string
    {
        return '/ ' . str_replace(' ', '\s+', implode('|', array_keys(self::MAP))) . ' /i';
    }
}
