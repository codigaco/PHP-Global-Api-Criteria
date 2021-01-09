<?php

namespace QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject;

use InvalidQueryMetadataException;

class QueryMetadata
{
    private $offset;
    private $limit;
    private $total;
    private $items;

    public function __construct(int $offset, int $limit, int $total, int $items)
    {
        self::validate($offset, $limit, $total, $items);
        $this->offset = $offset;
        $this->limit = $limit;
        $this->total = $total;
        $this->items = $items;
    }

    public static function validate(int $offset, int $limit, int $total, int $items): void
    {
        if ($offset < 0 || $limit < 0 || $total < 0 || $items < 0) {
            throw new InvalidQueryMetadataException("$offset, $limit, $total, $items");
        }
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
