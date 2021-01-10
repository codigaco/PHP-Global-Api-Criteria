<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\Exception\InvalidLimitException;

class Limit
{
    private $value;

    public function __construct(int $limit)
    {
        self::validate($limit);
        $this->value = $limit;
    }

    public static function validate(int $limit): void
    {
        if (0 > $limit) {
            throw new InvalidLimitException($limit);
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isZero(): bool
    {
        return 0 === $this->value;
    }
}
