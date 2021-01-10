<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;

class Criteria
{
    /** @var FilterGroup|null */
    private $filterGroup;

    /** @var OrderGroup|null */
    private $orderGroup;

    /** @var Paginate|null */
    private $paginate;

    /** @var FieldCriteriaRules[] */
    private static $rules;

    private function __construct(
        FilterGroup $filterGroup = null,
        OrderGroup $orderGroup = null,
        Paginate $paginate = null
    ) {
        $this->filterGroup = $filterGroup;
        $this->orderGroup = $orderGroup;
        $this->paginate = $paginate;
    }

    public static function create(): self
    {
        return new static();
    }

    public function withFilter(FilterGroup $filterGroup): self
    {
        $this->filterGroup = $filterGroup;
        return $this;
    }

    public function withOrder(OrderGroup $orderGroup): self
    {
        $this->orderGroup = $orderGroup;
        return $this;
    }

    public function withPaginate(Paginate $paginate): self
    {
        $this->paginate = $paginate;
        return $this;
    }

    public function filters(): ?FilterGroup
    {
        return $this->filterGroup;
    }

    public function orders(): ?OrderGroup
    {
        return $this->orderGroup;
    }

    public function paginate(): ?Paginate
    {
        return $this->paginate;
    }

    protected static function createRules(): array
    {
        return [];
    }

    public static function rules(): array
    {
        if (null === self::$rules) {
            self::$rules = self::createRules();
        }

        return self::$rules;
    }
}
