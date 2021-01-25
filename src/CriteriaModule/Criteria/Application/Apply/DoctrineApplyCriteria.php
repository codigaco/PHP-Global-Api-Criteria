<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Application\Apply;

use Doctrine\ORM\QueryBuilder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Application\Apply\DoctrineApplyFilter;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Application\Apply\DoctrineApplyOrder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Application\Apply\DoctrineApplyPaginate;
use TypeError;

class DoctrineApplyCriteria
{
    /**
     * @param $queryBuilder
     * @param Criteria $criteria
     * @param array $mapFields
     * @return QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder
     */
    public static function apply($queryBuilder, Criteria $criteria, array $mapFields = [])
    {
        if (!$queryBuilder instanceof QueryBuilder && !$queryBuilder instanceof \Doctrine\DBAL\Query\QueryBuilder) {
            throw new TypeError(gettype($queryBuilder));
        }

        if (null !== $criteria->filters()) {
            $queryBuilder = DoctrineApplyFilter::apply($queryBuilder, $criteria->filters(), $mapFields);
        }

        if (null !== $criteria->orders()) {
            $queryBuilder = DoctrineApplyOrder::apply($queryBuilder, $criteria->orders(), $mapFields);
        }

        if (null !== $criteria->paginate()) {
            $queryBuilder = DoctrineApplyPaginate::apply($queryBuilder, $criteria->paginate());
        }
        return $queryBuilder;
    }
}
