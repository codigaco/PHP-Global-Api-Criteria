<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Order\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Domain\Exception\InvalidOrderTypeException;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Domain\ValueObject\Order;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Domain\ValueObject\OrderType;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Field\Domain\Exception\InvalidFieldException;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Field\Domain\ValueObject\Field;

class OrderTest extends TestCase
{
    /** @test */
    public function invalid_instances(): void
    {
        $this->expectException(InvalidFieldException::class);
        Order::deserialize('-credit cart');


        $this->expectException(InvalidOrderTypeException::class);
        Order::deserialize('credit cart');
    }

    /** @test */
    public function deserialize(): void
    {
        $order = Order::deserialize('name');
        self::assertEquals('name', $order->field()->value());
        self::assertTrue($order->type()->isAsc());

        $order = Order::deserialize('+name');
        self::assertEquals('name', $order->field()->value());
        self::assertTrue($order->type()->isAsc());

        $order = Order::deserialize('-otherName');
        self::assertEquals('otherName', $order->field()->value());
        self::assertTrue($order->type()->isDesc());

        $order = Order::deserialize('name asc');
        self::assertEquals('name', $order->field()->value());
        self::assertTrue($order->type()->isAsc());

        $order = Order::deserialize('otherName desc');
        self::assertEquals('otherName', $order->field()->value());
        self::assertTrue($order->type()->isDesc());
    }

    /** @test */
    public function serialize(): void
    {
        $orderString = 'name';
        self::assertEquals($orderString, Order::deserialize($orderString)->serialize());
        self::assertEquals($orderString, (new Order(new Field('name'), new OrderType('')))->serialize());

        $orderString = '+name';
        self::assertEquals($orderString, Order::deserialize($orderString)->serialize());
        self::assertEquals($orderString, (new Order(new Field('name'), new OrderType('+')))->serialize());

        $orderString = '-name';
        self::assertEquals($orderString, Order::deserialize($orderString)->serialize());
        self::assertEquals($orderString, (new Order(new Field('name'), new OrderType('-')))->serialize());

        $orderString = 'name asc';
        self::assertEquals($orderString, Order::deserialize($orderString)->serialize());
        self::assertEquals($orderString, (new Order(new Field('name'), new OrderType('asc')))->serialize());

        $orderString = 'name desc';
        self::assertEquals($orderString, Order::deserialize($orderString)->serialize());
        self::assertEquals($orderString, (new Order(new Field('name'), new OrderType('desc')))->serialize());
    }
}
