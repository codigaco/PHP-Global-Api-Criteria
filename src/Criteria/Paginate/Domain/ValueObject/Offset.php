<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject;

class Offset
{
    private $value;

    public function __construct(int $offset)
    {
        $this->value = $offset;
    }


    public static function validate(int $offset): void
    {
        if (0 > $offset) {
            throw new \Exception('Invalid offset');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
