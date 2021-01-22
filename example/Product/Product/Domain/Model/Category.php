<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Model;

class Category
{
    private $id;
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
