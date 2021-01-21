<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\BaseFilter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\Order;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;
use TypeError;

class Criteria
{
    private static $rulesGroup = [];

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
        $this->paginate = $paginate ?? Paginate::unlimited();
    }

    public static function validate(?FilterGroup $filterGroup, ?OrderGroup $orderGroup): void
    {
        if (null !== $filterGroup) {
            self::rulesGroup()->assertRulesOfFilter($filterGroup);
        }
        if (null !== $orderGroup) {
            self::rulesGroup()->assertRulesOfOrder($orderGroup);
        }
    }

    public static function create(): self
    {
        return new static();
    }

    public function hasField(string $field): bool
    {
        return
            (null !== $this->filterGroup && $this->filterGroup->hasField($field))
            || (null !== $this->orderGroup && $this->orderGroup->hasField($field));
    }

    /**
     * @param FilterGroup|Filter|string|null $filterGroup
     * @return Criteria
     */
    public function withFilter($filterGroup): self
    {
        if (!$filterGroup instanceof BaseFilter && !is_string($filterGroup) && !is_null($filterGroup)) {
            throw new TypeError(gettype($filterGroup));
        }

        if ($filterGroup instanceof Filter) {
            $filterGroup = FilterGroup::create($filterGroup);
        }

        if (is_string($filterGroup)) {
            $filterGroup = FilterGroup::deserialize($filterGroup);
        }

        if (!is_null($filterGroup)) {
            self::rulesGroup()->assertRulesOfFilter($filterGroup);
        }

        $this->filterGroup = $filterGroup;
        return $this;
    }

    /**
     * @param OrderGroup|Order|string|null $orderGroup
     * @return Criteria
     */
    public function withOrder($orderGroup): self
    {
        if (!$orderGroup instanceof OrderGroup && !$orderGroup instanceof Order && !is_string($orderGroup) && !is_null($orderGroup)) {
            throw new TypeError(gettype($orderGroup));
        }

        if ($orderGroup instanceof Order) {
            $orderGroup = OrderGroup::create()->add($orderGroup);
        }

        if (is_string($orderGroup)) {
            $orderGroup = OrderGroup::deserialize($orderGroup);
        }

        if (!is_null($orderGroup)) {
            self::rulesGroup()->assertRulesOfOrder($orderGroup);
        }

        $this->orderGroup = $orderGroup;
        return $this;
    }

    /**
     * @param Paginate|string|null $paginate
     * @return Criteria
     */
    public function withPaginate($paginate): self
    {
        if (!$paginate instanceof Paginate && !is_string($paginate) && !is_null($paginate)) {
            throw new TypeError(gettype($paginate));
        }

        if (is_string($paginate)) {
            $paginate = Paginate::deserialize($paginate);
        }

        if (is_null($paginate)) {
            $paginate = Paginate::unlimited();
        }

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

    public function paginate(): Paginate
    {
        return $this->paginate;
    }

    protected static function createRules(): array
    {
        return [];
    }

    public static function rulesGroup(): FieldCriteriaRulesGroup
    {
        if (!isset(static::$rulesGroup[static::class])) {
            static::$rulesGroup[static::class] = new FieldCriteriaRulesGroup(...static::createRules());
        }

        return self::$rulesGroup[static::class];
    }
}
