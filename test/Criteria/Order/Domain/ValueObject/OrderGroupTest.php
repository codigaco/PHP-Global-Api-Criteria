<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Criteria\Order\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\Exception\InvalidOrderTypeException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Shared\Domain\Exception\InvalidFieldException;

class OrderGroupTest extends TestCase
{
    /** @test */
    public function invalid_instances(): void
    {
        $this->expectException(InvalidFieldException::class);
        OrderGroup::deserialize('-credit cart, name desc');


        $this->expectException(InvalidOrderTypeException::class);
        OrderGroup::deserialize('credit cart, name asc');
    }

    /** @test */
    public function deserialize(): void
    {
        $orderGroup = OrderGroup::deserialize('+name,-lastName');
        self::assertEquals(2, $orderGroup->count());
        self::assertEquals('name', $orderGroup->get(0)->field()->value());
        self::assertTrue($orderGroup->get(0)->type()->isAsc());
        self::assertEquals('lastName', $orderGroup->get(1)->field()->value());
        self::assertTrue($orderGroup->get(1)->type()->isDesc());

        $orderGroup = OrderGroup::deserialize('-otherName');
        self::assertEquals(1, $orderGroup->count());
        self::assertEquals('otherName', $orderGroup->get(0)->field()->value());
        self::assertTrue($orderGroup->get(0)->type()->isDesc());

        $orderGroup = OrderGroup::deserialize('age desc, name, -lastName');
        self::assertEquals(3, $orderGroup->count());
        self::assertEquals('age', $orderGroup->get(0)->field()->value());
        self::assertTrue($orderGroup->get(0)->type()->isDesc());
        self::assertEquals('name', $orderGroup->get(1)->field()->value());
        self::assertTrue($orderGroup->get(1)->type()->isAsc());
        self::assertEquals('lastName', $orderGroup->get(2)->field()->value());
        self::assertTrue($orderGroup->get(2)->type()->isDesc());

    }

    /** @test */
    public function serialize(): void
    {
        $orderString = '+name,-lastName';
        $orderGroup = OrderGroup::deserialize($orderString);
        self::assertEquals($orderString, $orderGroup->serialize());

        $orderString = '-otherName';
        $orderGroup = OrderGroup::deserialize($orderString);
        self::assertEquals($orderString, $orderGroup->serialize());

        $orderString = 'age desc, name, -lastName';
        $orderGroup = OrderGroup::deserialize($orderString);
        self::assertEquals('age desc,name,-lastName', $orderGroup->serialize());
    }
}
