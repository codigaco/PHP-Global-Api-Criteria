<?php

namespace QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Application\ApplyCriteria;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;

class ApplyCriteriaArray
{


    public static function apply(Criteria $criteria, array $array): array
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

    private static function applyOrderGroup(OrderGroup $orderGroup, array $array): array
    {
        usort($array,
            static function ($a, $b) use ($orderGroup) {
                foreach ($orderGroup->orders() as $order) {
                    $response = $a[$order->field()->value()] <=> $b[$order->field()->value()];
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

    public static function applyFilterGroup(FilterGroup $filterGroup, array $array): array
    {
        return array_values(array_filter($array,
            static function ($item) use ($filterGroup) {
                return self::applyFilter($filterGroup, $item);
            }));
    }

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
            throw new \Exception('wiiiiiiiiiiiiiii');
        }

        $value = $element[$filter->field()->value()];

        if ($filter->operator()->isEqual()) {
            return $value == $filter->value()->scalar();
        }
        if ($filter->operator()->isNotEqual()) {
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

        throw new \Exception('jajajajaja');
    }


}
