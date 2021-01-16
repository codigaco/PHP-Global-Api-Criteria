<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Application\ApplyCriteria;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\Exception\InvalidComparisonOperatorException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;
use QuiqueGilB\GlobalApiCriteria\Shared\Utils\Domain\Helper\Obj;
use ReflectionException;
use TypeError;

class ApplyCriteriaArray
{
    /**
     * @param Criteria $criteria
     * @param array $array
     * @param array $mapFields
     * @return array
     * @throws ReflectionException
     */
    public static function apply(Criteria $criteria, array $array, array $mapFields = []): array
    {
        $array = self::applyFilterGroup($criteria->filters(), $array);
        $array = self::applyOrderGroup($criteria->orders(), $array);
        $array = self::applyPaginate($criteria->paginate(), $array);
        return $array;
    }

    private static function applyPaginate(Paginate $paginate, array $array): array
    {
        return array_values(array_slice($array, $paginate->offset()->value(), $paginate->limit()->value()));
    }

    /**
     * @param OrderGroup $orderGroup
     * @param array $array
     * @return array
     * @throws ReflectionException
     */
    private static function applyOrderGroup(OrderGroup $orderGroup, array $array): array
    {
        usort($array,
            static function ($a, $b) use ($orderGroup) {
                foreach ($orderGroup->orders() as $order) {
                    $response = Obj::get($a, $order->field()->value()) <=> Obj::get($b, $order->field()->value());
                    if ($order->type()->isDesc()) {
                        $response *= -1;
                    }
                    if ($response !== 0) {
                        return $response;
                    }
                }
                return 0;
            });
        return array_values($array);
    }

    /**
     * @param FilterGroup $filterGroup
     * @param array $array
     * @return array
     * @throws ReflectionException
     */
    public static function applyFilterGroup(FilterGroup $filterGroup, array $array): array
    {
        return array_values(array_filter($array,
            static function ($item) use ($filterGroup) {
                return self::applyFilter($filterGroup, $item);
            }));
    }

    /**
     * @param $filter
     * @param $element
     * @return bool
     * @throws ReflectionException
     */
    private static function applyFilter($filter, $element): bool
    {
        if ($filter instanceof FilterGroup) {
            $isValid = true;
            foreach ($filter->filters() as $item) {
                $response = self::applyFilter($item, $element);

                $isValid = $item->logicalOperator()->isAnd()
                    ? $isValid && $response
                    : $isValid || $response;
            }
            return $isValid;
        }

        if (!$filter instanceof Filter) {
            throw new TypeError(get_class($filter));
        }

        $value = Obj::get($element, $filter->field()->value());

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
