<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Order\Domain\ValueObject;


use PHPUnit\Util\Exception;

class OrderType
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    private $value;

    public function __construct(string $orderType)
    {
        self::validate($orderType);
        $this->value = $orderType;
    }

    private static function validate(string $orderType)
    {
        if (self::ASC !== $orderType && self::DESC !== $orderType) {
            throw new Exception('Invalid order type');
        }
    }

}
