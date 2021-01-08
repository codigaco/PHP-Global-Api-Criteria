<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\Exception\InvalidComparisonOperatorException;

class ComparisonOperator
{
    private const EQUAL = 'eq';
    private const NOT_EQUAL = 'ne';
    private const GREATER = 'gt';
    private const GREATER_OR_EQUAL = 'ge';
    private const LESS = 'lt';
    private const LESS_OR_EQUAL = 'le';
    private const IN = 'in';
    private const LIKE = 'like';

    private const MAP = [
        "=" => self::EQUAL,
        "eq" => self::EQUAL,
        "is" => self::EQUAL,

        "!=" => self::NOT_EQUAL,
        "<>" => self::NOT_EQUAL,
        "ne" => self::NOT_EQUAL,

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

        "like" => self::LIKE,
        "contains" => self::LIKE
    ];

    private $value;

    public function __construct(string $operator)
    {
        $operator = strtolower($operator);
        self::validate($operator);
        $this->value = self::MAP[$operator];
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

    public function isEqual(): bool
    {
        return self::MAP[$this->value] === self::EQUAL;
    }

    public function isNotEqual(): bool
    {
        return self::MAP[$this->value] === self::NOT_EQUAL;
    }

    public function isGreater(): bool
    {
        return self::MAP[$this->value] === self::GREATER;
    }

    public function isGreaterOrEqual(): bool
    {
        return self::MAP[$this->value] === self::GREATER_OR_EQUAL;
    }

    public function isLess(): bool
    {
        return self::MAP[$this->value] === self::LESS;
    }

    public function isLessOrEqual(): bool
    {
        return self::MAP[$this->value] === self::LESS_OR_EQUAL;
    }

    public function isIn(): bool
    {
        return self::MAP[$this->value] === self::IN;
    }

    public function isLike(): bool
    {
        return self::MAP[$this->value] === self::LIKE;
    }
}
