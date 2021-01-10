<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;

class Criteria
{
    private static $rulesGroup;

    private $filterGroup;
    private $orderGroup;
    private $paginate;

    private function __construct(
        FilterGroup $filterGroup = null,
        OrderGroup $orderGroup = null,
        Paginate $paginate = null
    ) {
        self::validate($filterGroup, $orderGroup);

        $this->filterGroup = $filterGroup;
        $this->orderGroup = $orderGroup;
        $this->paginate = $paginate;
    }

    public static function validate(?FilterGroup $filterGroup, ?OrderGroup $orderGroup): void
    {
        self::assertRulesFilterGroup($filterGroup);
        self::assertRulesOrderGroup($orderGroup);
    }

    private static function assertRulesFilterGroup(?FilterGroup $filterGroup): void
    {
        if (null === $filterGroup) {
            return;
        }

        /** @var Filter|FilterGroup $filter */
        foreach ($filterGroup->filters() as $filter) {
            if ($filter instanceof FilterGroup) {
                self::assertRulesFilterGroup($filter);
                continue;
            }



        }
    }

    private static function assertRulesOrderGroup(?OrderGroup $orderGroup): void
    {
        if (null === $orderGroup) {
            return;
        }

    }


    public static function create(): self
    {
        return new static();
    }

    public function withFilter(FilterGroup $filterGroup): self
    {
        self::assertRulesFilterGroup($filterGroup);
        $this->filterGroup = $filterGroup;
        return $this;
    }

    public function withOrder(OrderGroup $orderGroup): self
    {
        self::assertRulesOrderGroup($orderGroup);
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

    public static function rulesGroup(): array
    {
        if (null === self::$rulesGroup) {
            self::$rulesGroup = new FieldCriteriaRulesGroup(self::createRules());
        }

        return self::$rulesGroup->rules();
    }
}
