<?php

namespace QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject;

use InvalidQueryMetadataException;

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

    public static function validate(int $offset, int $limit, int $total): void
    {
        if ($offset < 0 || $limit < 0 || $total < 0) {
            throw new InvalidQueryMetadataException("$offset, $limit, $total");
        }
    }

    private function calculateItems(): int
    {
        if (0 === $this->offset) {
            return min($this->limit, $this->total);
        }

        if (0 === $this->limit) {
            return $this->total - $this->offset;
        }

        $items = $this->offset + $this->limit > $this->total
            ? $this->total - $this->offset
            : $this->limit;

        return $items < 0 ? 0 : $items;
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
