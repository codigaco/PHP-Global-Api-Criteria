<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model;

class Product
{
    private $id;
    private $name;
    private $price;
    private $stock;
    private $categories;

    public function __construct(int $id, string $name, float $price, int $stock, Category ...$categories)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->categories = $categories;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function stock(): int
    {
        return $this->stock;
    }

    public function categories(): array
    {
        return $this->categories;
    }
}
