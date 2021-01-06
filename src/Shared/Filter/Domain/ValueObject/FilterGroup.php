<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject;

use PHPUnit\Util\Exception;

class FilterGroup
{
    private $value;

    private function __construct()
    {
        $this->value = [];
    }

    public static function createWithAnds(...$filters): self
    {
        $group = new static();
        foreach ($filters as $filter) {
            $group->and($filter);
        }

        return $group;
    }

    /**
     * @param Filter|FilterGroup|null $filter
     * @return FilterGroup
     */
    public static function create($filter = null): self
    {
        $instance = new static();
        if (null !== $filter) {
            $instance->and($filter);
        }
        return $instance;
    }

    /**
     * @param Filter|FilterGroup $filter
     * @return FilterGroup
     */
    public function and($filter): self
    {
        return $this->add(LogicalOperator::and(), $filter);
    }

    /**
     * @param Filter|FilterGroup $filter
     * @return FilterGroup
     */
    public function or(Filter $filter): self
    {
        return $this->add(LogicalOperator::or(), $filter);
    }

    public function hasOnlyOne(): bool
    {
        return count($this->value) === 1;
    }

    public function forEach(callable $callable, bool $recursive = false): void
    {
        foreach ($this->value as $value) {
            $callable($value[0], $value[1]);

            if (true === $recursive && $value[1] instanceof FilterGroup) {
                $value[1]->forEach($callable, $recursive);
            }
        }
    }


    /**
     * @param LogicalOperator $logicalOperator
     * @param Filter|FilterGroup $filter
     * @return FilterGroup
     */
    public function add(LogicalOperator $logicalOperator, $filter): self
    {
        if (!$filter instanceof FilterGroup && !$filter instanceof Filter) {
            throw new Exception('Invalid filter');
        }

        $this->value[] = [
            $logicalOperator,
            $filter
        ];

        return $this;
    }
}
