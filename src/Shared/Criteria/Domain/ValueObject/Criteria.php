<?php


use QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Shared\Order\Domain\ValueObject\Order;
use QuiqueGilB\GlobalApiCriteria\Shared\Paginate\Domain\ValueObject\Paginate;

class Criteria
{
    /** @var FilterGroup|null */
    private $filterGroup;

    /** @var Order[] */
    private $orders;

    /** @var Paginate|null */
    private $paginate;

    private function __construct()
    {
        $this->filterGroup = null;
        $this->orders = [];
        $this->paginate = null;
    }

    public static function create(): self
    {
        return new static();
    }

    public function filterGroup(): ?FilterGroup
    {
        return $this->filterGroup;
    }

    public function orders(): array
    {
        return $this->orders;
    }

    public function paginate(): ?Paginate
    {
        return $this->paginate;
    }


}
