<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\Exception\InvalidOrderTypeException;

class OrderType
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    private const MAP = [
        'asc' => self::ASC,
        '+' => self::ASC,
        '' => self::ASC,

        'desc' => self::DESC,
        '-' => self::DESC,
    ];

    private $value;

    public function __construct(string $orderType)
    {
        self::validate($orderType);
        $this->value = $orderType;
    }

    private static function validate(string $orderType): void
    {
        if (!isset(self::MAP[$orderType])) {
            throw new InvalidOrderTypeException($orderType);
        }
    }

    public function isAsc(): bool
    {
        return self::MAP[$this->value] === self::ASC;
    }

    public function isDesc(): bool
    {
        return self::MAP[$this->value] === self::DESC;
    }

    public function value(): string
    {
        return $this->value;
    }
}
