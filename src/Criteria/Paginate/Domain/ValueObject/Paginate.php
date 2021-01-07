<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject;

class Paginate
{
    private $limit;
    private $offset;

    public function __construct(?Limit $limit, Offset $offset = null)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function limit(): ?Limit
    {
        return $this->limit;
    }

    public function offset(): ?Offset
    {
        return $this->offset;
    }

    public function create(?Limit $limit, Offset $offset = null)
    {
        return new static($limit, $offset);
    }


    public static function unlimited(): self
    {
        return new static(null, null);
    }
}
