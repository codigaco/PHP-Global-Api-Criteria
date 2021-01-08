<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject;

class OrderGroup
{
    /** @var Order[] */
    private $orders;

    public function __construct()
    {
        $this->orders = [];
    }

    private function add(Order $order): self
    {
        $this->orders[] = $order;
        return $this;
    }

    public function count(): int
    {
        return count($this->orders);
    }

    public function orders(): array
    {
        return $this->orders;
    }

    public function get(int $index): Order
    {
        return $this->orders[$index];
    }

    public static function deserialize(string $stringOrders): self
    {
        $orderGroup = new static();
        $orders = explode(',', $stringOrders);

        foreach ($orders as $order) {
            $orderGroup->add(Order::deserialize($order));
        }

        return $orderGroup;
    }

    public static function create(): self
    {
        return new static();
    }

    public function serialize(): string
    {
        $serializes = [];
        foreach ($this->orders as $order) {
            $serializes[] = $order->serialize();
        }
        return implode(',', $serializes);
    }
}
