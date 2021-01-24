<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Order\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Domain\Exception\InvalidOrderTypeException;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Domain\ValueObject\OrderType;

class OrderTypeTest extends TestCase
{
    /** @test */
    public function instances(): void
    {
        self::assertTrue((new OrderType('asc'))->isAsc());
        self::assertTrue((new OrderType('+'))->isAsc());
        self::assertTrue((new OrderType('desc'))->isDesc());
        self::assertTrue((new OrderType('-'))->isDesc());
    }

    /** @test */
    public function invalid_instances(): void
    {
        $this->expectException(InvalidOrderTypeException::class);
        new OrderType('top');

        $this->expectException(InvalidOrderTypeException::class);
        new OrderType('.');

        $this->expectException(InvalidOrderTypeException::class);
        new OrderType('descendent');

        $this->expectException(InvalidOrderTypeException::class);
        new OrderType('down');
    }
}
