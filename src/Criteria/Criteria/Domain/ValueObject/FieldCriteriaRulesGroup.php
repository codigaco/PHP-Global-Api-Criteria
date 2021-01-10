<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\Exception\FieldCriteriaRulesRepeatException;

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

    public function getApplyRuleByField(string $field): ?FieldCriteriaRules
    {
        if (isset($this->matches[$field])) {
            return $this->matches[$field];
        }

        $rule = null;

        $this->matches[$field] = $rule;
        return $rule;
    }

}
