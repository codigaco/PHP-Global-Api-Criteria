<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\Exception\InvalidOffsetException;

class Offset
{
    private $value;

    public function __construct(int $offset)
    {
        self::validate($offset);
        $this->value = $offset;
    }

    public static function validate(int $offset): void
    {
        if (0 > $offset) {
            throw new InvalidOffsetException($offset);
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
