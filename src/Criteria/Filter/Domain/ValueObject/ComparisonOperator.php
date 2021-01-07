<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject;

use PHPUnit\Util\Exception;

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
        self::validate($operator);
        $this->value = self::MAP[$operator];
    }

    public static function validate(string $operator): void
    {
        if (!in_array($operator, array_keys(self::MAP))) {
            throw new Exception('Invalid comparison operator');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
