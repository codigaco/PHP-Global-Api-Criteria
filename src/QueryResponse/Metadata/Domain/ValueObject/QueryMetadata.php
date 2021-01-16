<?php

namespace QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\Exception\InvalidQueryMetadataException;

class QueryMetadata
{
    private $offset;
    private $limit;
    private $total;
    private $items;

    public function __construct(int $offset, int $limit, int $total)
    {
        self::validate($offset, $limit, $total);
        $this->offset = $offset;
        $this->limit = $limit;
        $this->total = $total;
        $this->items = $this->calculateItems();
    }

    public static function create(int $offset, int $limit, int $total): self
    {
        return new static($offset, $limit, $total);
    }

    public static function validate(int $offset, int $limit, int $total): void
    {
        if ($offset < 0 || $limit < 0 || $total < 0) {
            throw new InvalidQueryMetadataException("$offset, $limit, $total");
        }
    }

    private function calculateItems(): int
    {
        $items = max($this->total, $this->offset) - $this->offset;
        return 0 === $this->limit ? $items : min($items, $this->limit);
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function items(): int
    {
        return $this->items;
    }
}
