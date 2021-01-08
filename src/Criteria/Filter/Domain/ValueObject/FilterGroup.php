<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\Factory\FilterGroupFactory;

class FilterGroup extends BaseFilter
{
    /** @var BaseFilter[] */
    private $value;

    private function __construct()
    {
        $this->value = [];
    }

    public static function create(BaseFilter $filter = null): self
    {
        $instance = new static();
        if (null !== $filter) {
            $instance->and($filter);
        }
        return $instance;
    }

    /**
     * @param int $index
     * @return FilterGroup|Filter
     */
    public function get(int $index): BaseFilter
    {
        return $this->value[$index];
    }

    public function and(BaseFilter $filter): self
    {
        return $this->add(LogicalOperator::and(), $filter);
    }

    public function or(BaseFilter $filter): self
    {
        return $this->add(LogicalOperator::or(), $filter);
    }

    public function hasOnlyOne(): bool
    {
        return count($this->value) === 1;
    }

    public function add(LogicalOperator $logicalOperator, BaseFilter $filter): self
    {
        $this->value[] = $filter->setLogicOperator($logicalOperator);
        return $this;
    }

    public static function deserialize(string $filter): self
    {
        return FilterGroupFactory::fromString($filter);
    }

    public function serialize(): string
    {
        $serialized = '';

        foreach ($this->value as $baseFilter) {
            $expresion = sprintf(
                $baseFilter instanceof self ? '(%s)' : '%s',
                $baseFilter->serialize()
            );
            $serialized .= ('' === $serialized ? '' : ' ' . $baseFilter->logicalOperator()->value()) . ' ' . $expresion;
        }

        return trim($serialized);
    }
}
