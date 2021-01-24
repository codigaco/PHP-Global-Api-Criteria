<?php

namespace QuiqueGilB\GlobalApiCriteria\QueryResponseModule\Metadata\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\Metadata\Domain\Exception\InvalidQueryMetadataException;

class QueryMetadata
{
    private $offset;
    private $limit;
    private $total;
    private $items;
    private $pages;
    private $currentPage;

    public function __construct(int $offset, int $limit, int $total)
    {
        self::validate($offset, $limit, $total);
        $this->offset = $offset;
        $this->limit = $limit;
        $this->total = $total;
        $this->items = $this->calculateItems();
        $this->pages = $this->calculatePages();
        $this->currentPage = $this->calculateCurrentPage();
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

    private function calculatePages(): int
    {
        if (0 !== $this->limit) {
            return ceil($this->total / $this->limit);
        }

        return 0 === $this->offset ? 1 : 2;
    }

    private function calculateCurrentPage(): int
    {
        if (0 !== $this->limit) {
            return 1 + floor($this->offset / $this->limit);
        }

        return 0 === $this->offset ? 1 : 2;
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

    public function pages(): int
    {
        return $this->pages;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }
}
