<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject;

class Limit
{
    private $value;

    public function __construct(int $limit)
    {
        $this->value = $limit;
    }

    public static function validate(int $limit): void
    {
        if (0 > $limit) {
            throw new \Exception('Invalid limit');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
