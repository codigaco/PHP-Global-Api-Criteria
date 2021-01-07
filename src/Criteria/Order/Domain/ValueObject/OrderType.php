<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject;


use PHPUnit\Util\Exception;

class OrderType
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    private const MAP = [
        'asc' => self::ASC,
        '+' => self::ASC,

        'desc' => self::DESC,
        '-' => self::DESC,
    ];

    private $value;

    public function __construct(string $orderType)
    {
        $orderType = self::MAP[$orderType] ?? '';
        self::validate($orderType);
        $this->value = $orderType;
    }

    private static function validate(string $orderType)
    {
        if (self::ASC !== $orderType && self::DESC !== $orderType) {
            throw new Exception('Invalid order type');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

}
