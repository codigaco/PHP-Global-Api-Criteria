<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Application\Apply;

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\Exception\InvalidComparisonOperatorException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Shared\Utils\Domain\Helper\Obj;
use ReflectionException;
use TypeError;

class ArrayApplyFilter
{
    public static function apply(array $array, FilterGroup $filterGroup, array $mapFields = []): array
    {
        return array_values(array_filter($array,
            static function ($item) use ($mapFields, $filterGroup) {
                return self::applyFilter($filterGroup, $item, $mapFields);
            }
        ));
    }

    /**
     * @param FilterGroup|Filter $filter
     * @param object|array $element
     * @param array $mapFields
     * @return bool
     * @throws ReflectionException
     */
    private static function applyFilter($filter, $element, $mapFields): bool
    {
        if ($filter instanceof FilterGroup) {
            $isValid = true;
            foreach ($filter->filters() as $item) {
                $response = self::applyFilter($item, $element, $mapFields);

                $isValid = $item->logicalOperator()->isAnd()
                    ? $isValid && $response
                    : $isValid || $response;
            }
            return $isValid;
        }

        if (!$filter instanceof Filter) {
            throw new TypeError(get_class($filter));
        }

        $mapped = $mapFields[$filter->field()->value()] ?? $filter->field()->value();

        $value = is_callable($mapped)
            ? $mapped($element)
            : Obj::get($element, $mapped);

        if ($filter->operator()->isEqual()) {
            /** @noinspection TypeUnsafeComparisonInspection */
            return $value == $filter->value()->scalar();
        }
        if ($filter->operator()->isNotEqual()) {
            /** @noinspection TypeUnsafeComparisonInspection */
            return $value != $filter->value()->scalar();
        }
        if ($filter->operator()->isLike()) {
            return false !== strpos($value, $filter->value()->scalar());
        }
        if ($filter->operator()->isIn()) {
            return in_array($value, $filter->value()->scalar(), true);
        }
        if ($filter->operator()->isLess()) {
            return $value < $filter->value()->scalar();
        }
        if ($filter->operator()->isLessOrEqual()) {
            return $value <= $filter->value()->scalar();
        }
        if ($filter->operator()->isGreater()) {
            return $value > $filter->value()->scalar();
        }
        if ($filter->operator()->isGreaterOrEqual()) {
            return $value >= $filter->value()->scalar();
        }

        throw new InvalidComparisonOperatorException($filter->operator()->value());
    }

}
