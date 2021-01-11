<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\Exception\FieldCriteriaRulesRepeatException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\Exception\FieldCriteriaRuleViolationException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\Exception\InvalidFieldCriteriaRuleForAssertFieldException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\BaseFilter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\Order;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;

class FieldCriteriaRulesGroup
{
    private $matches = [];
    private $rules;

    public function __construct(FieldCriteriaRules ...$rules)
    {
        self::validate(...$rules);
        $this->rules = $rules;
    }

    public function rules(): array
    {
        return $this->rules;
    }

    private static function validate(FieldCriteriaRules ...$rules): void
    {
        $fields = array_map(static function (FieldCriteriaRules $rule) {
            return $rule->field()->value();
        },
            $rules);

        $fieldsDuplicated = array_keys(array_filter(array_count_values($fields),
            static function ($counted) {
                return $counted > 1;
            }));

        if (!empty($fieldsDuplicated)) {
            throw new FieldCriteriaRulesRepeatException(implode(', ', $fieldsDuplicated));
        }
    }

    public function assertRulesOfCriteria(Criteria $criteria): void
    {
        if (false === $this->hasRules()) {
            return;
        }
        $this->assertRulesOfFilter($criteria->filters());
        $this->assertRulesOfOrder($criteria->orders());

    }

    public function assertRulesOfOrder($order): void
    {
        if (false === $this->hasRules()) {
            return;
        }
        if ($order instanceof OrderGroup) {
            foreach ($order->orders() as $orderElement) {
                $this->assertRulesOfOrder($orderElement);
            }
            return;
        }
        if (!$order instanceof Order) {
            throw new InvalidFieldCriteriaRuleForAssertFieldException(get_class($order));
        }

        $rule = $this->getApplyRuleByField($order->field()->value());
        if (null === $rule) {
            throw new InvalidFieldCriteriaRuleForAssertFieldException($order->serialize());
        }

        $rule->assertOrder($order);
    }

    public function assertRulesOfFilter(BaseFilter $filter): void
    {
        if (false === $this->hasRules()) {
            return;
        }

        if($filter instanceof FilterGroup) {
            foreach ($filter->filters() as $filterElement) {
                $this->assertRulesOfFilter($filterElement);
            }
            return;
        }

        if (!$filter instanceof Filter) {
            throw new InvalidFieldCriteriaRuleForAssertFieldException(get_class($filter));
        }

        $rule = $this->getApplyRuleByField($filter->field()->value());
        if (null === $rule) {
            throw new InvalidFieldCriteriaRuleForAssertFieldException($filter->serialize());
        }

        $rule->assertFilter($filter);


    }

    public function getApplyRuleByField(string $field): ?FieldCriteriaRules
    {
        if (isset($this->matches[$field])) {
            return $this->matches[$field];
        }

        $tmpRule = null;
        $rate = 0;
        foreach ($this->rules as $rule) {
            if ($rule->field()->has($field)) {
                $length = strlen($field);
                if ($rate < $length) {
                    $rate = $length;
                    $tmpRule = $rule;
                }
            }
        }

        $this->matches[$field] = $tmpRule;
        return $tmpRule;
    }

    public function hasRules(): bool
    {
        return 0 < count($this->rules);
    }
}
