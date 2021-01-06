<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Paginate\Domain\ValueObject;

use PHPUnit\Util\Exception;

class Paginate
{
    private $limit;
    private $offset;

    public function __construct(?Limit $limit, ?Offset $offset)
    {
        self::validate($limit, $offset);

        $this->limit = $limit;
        $this->offset = $offset;
    }

    public static function validate(?Limit $limit, ?Offset $offset): void
    {
        if (null === $limit && null === $offset) {
            throw new Exception("Paginate requires at least offset or limit ");
        }
    }

    public function limit(): ?Limit
    {
        return $this->limit;
    }

    public function offset(): ?Offset
    {
        return $this->offset;
    }
}
