<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject;

use PHPUnit\Util\Exception;

class ComparisonOperator
{
    public const EQUAL = 'eq';
    public const NOT_EQUAL = 'ne';
    public const GREATER = 'gt';
    public const GREATER_OR_EQUAL = 'ge';
    public const LESS = 'lt';
    public const LESS_OR_EQUAL = 'le';

    private const MAP = [
        "=" => self::EQUAL,
        "eq" => self::EQUAL,

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
        "lte" => self::LESS_OR_EQUAL
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
}
