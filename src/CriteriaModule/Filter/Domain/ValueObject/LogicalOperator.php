<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\Exception\InvalidLogicalOperatorException;

class LogicalOperator
{
    public const AND = 'and';
    public const OR = 'or';

    private const MAP = [
        "&&" => self:: AND,
        "and" => self:: AND,

        "||" => self:: OR,
        "or" => self:: OR,
    ];

    private $value;

    public function __construct(string $operator)
    {
        $operator = strtolower($operator);
        self::validate($operator);
        $this->value = $operator;
    }

    public static function validate(string $operator): void
    {
        if (!array_key_exists($operator, self::MAP)) {
            throw new InvalidLogicalOperatorException($operator);
        }
    }

    public static function create(string $operator): self
    {
        return new static($operator);
    }

    public static function and(): self
    {
        return new static(self:: AND);
    }

    public static function or(): self
    {
        return new static(self:: OR);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isAnd(): bool
    {
        return self::MAP[$this->value] === self:: AND;
    }

    public function isOr(): bool
    {
        return self::MAP[$this->value] === self:: OR;
    }

    public static function regex(): string
    {
        return '/^(and|or|&&|\|\|)$/i';
    }
}
