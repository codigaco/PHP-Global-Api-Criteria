<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\Exception\LogicalOperatorViolationException;

abstract class BaseFilter
{
    private $logicalOperator;

    public function logicalOperator(): LogicalOperator
    {
        return $this->logicalOperator ?? LogicalOperator::and();
    }

    protected function setLogicOperator(LogicalOperator $logicalOperator): self
    {
        if (null === $this->logicalOperator) {
            $this->logicalOperator = $logicalOperator;
            return $this;
        }
        throw new LogicalOperatorViolationException('Not possible modify logical operator');
    }
}
