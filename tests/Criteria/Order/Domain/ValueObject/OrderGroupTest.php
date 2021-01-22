<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\Criteria\Order\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\Exception\InvalidOrderTypeException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\Order;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderType;
use QuiqueGilB\GlobalApiCriteria\Shared\Field\Domain\Exception\InvalidFieldException;
use QuiqueGilB\GlobalApiCriteria\Shared\Field\Domain\ValueObject\Field;

class OrderGroupTest extends TestCase
{
    /** @test */
    public function has_orders(): void
    {
        self::assertCount(1, OrderGroup::deserialize('name')->orders());
    }

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

    /** @test */
    public function building(): void
    {
        $orderGroup = OrderGroup::create()
            ->add(new Order(new Field('aField'), new OrderType('asc')))
            ->add(new Order(new Field('otherField'), new OrderType('desc')))
            ->add(new Order(new Field('name')));

        self::assertEquals(3, $orderGroup->count());
        self::assertEquals('aField', $orderGroup->get(0)->field()->value());
        self::assertEquals('asc', $orderGroup->get(0)->type()->value());
        self::assertEquals('otherField', $orderGroup->get(1)->field()->value());
        self::assertEquals('desc', $orderGroup->get(1)->type()->value());
        self::assertEquals('name', $orderGroup->get(2)->field()->value());
        self::assertEquals('', $orderGroup->get(2)->type()->value());
    }
}
