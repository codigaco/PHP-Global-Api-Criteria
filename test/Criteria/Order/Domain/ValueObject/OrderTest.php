<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Criteria\Order\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\Exception\InvalidOrderException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\Exception\InvalidOrderTypeException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\Order;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderType;
use QuiqueGilB\GlobalApiCriteria\Shared\Domain\Exception\InvalidFieldException;
use QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject\Field;

class OrderTest extends TestCase
{
    /** @test */
    public function invalid_instances()
    {
        $this->expectException(InvalidFieldException::class);
        Order::deserialize('-credit cart');


        $this->expectException(InvalidOrderTypeException::class);
        Order::deserialize('credit cart');
    }

    /** @test */
    public function deserialize(): void
    {
        $order = Order::deserialize('+name');
        $this->assertEquals('name', $order->field()->value());
        $this->assertTrue($order->type()->isAsc());

        $order = Order::deserialize('-otherName');
        $this->assertEquals('otherName', $order->field()->value());
        $this->assertTrue($order->type()->isDesc());

        $order = Order::deserialize('name asc');
        $this->assertEquals('name', $order->field()->value());
        $this->assertTrue($order->type()->isAsc());

        $order = Order::deserialize('otherName desc');
        $this->assertEquals('otherName', $order->field()->value());
        $this->assertTrue($order->type()->isDesc());
    }

    /** @test */
    public function serialize(): void
    {
        $orderString = '+name';
        $this->assertEquals($orderString, Order::deserialize($orderString)->serialize());
        $this->assertEquals($orderString, (new Order(new Field('name'), new OrderType('+')))->serialize());

        $orderString = '-name';
        $this->assertEquals($orderString, Order::deserialize($orderString)->serialize());
        $this->assertEquals($orderString, (new Order(new Field('name'), new OrderType('-')))->serialize());

        $orderString = 'name asc';
        $this->assertEquals($orderString, Order::deserialize($orderString)->serialize());
        $this->assertEquals($orderString, (new Order(new Field('name')))->serialize());
        $this->assertEquals($orderString, (new Order(new Field('name'), new OrderType('asc')))->serialize());

        $orderString = 'name desc';
        $this->assertEquals($orderString, Order::deserialize($orderString)->serialize());
        $this->assertEquals($orderString, (new Order(new Field('name'), new OrderType('desc')))->serialize());
    }

}
