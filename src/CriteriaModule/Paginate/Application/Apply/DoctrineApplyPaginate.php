<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Application\Apply;

use Doctrine\ORM\QueryBuilder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject\Paginate;
use TypeError;

class DoctrineApplyPaginate
{
    /**
     * @param QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $builder
     * @param Paginate $paginate
     * @return QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder
     */
    public static function apply($builder, Paginate $paginate)
    {
        if (!$builder instanceof QueryBuilder && !$builder instanceof \Doctrine\DBAL\Query\QueryBuilder) {
            throw new TypeError(gettype($builder));
        }

        if (false === $paginate->offset()->isZero()) {
            $builder->setFirstResult($paginate->offset()->value());
        }

        if (false === $paginate->limit()->isZero()) {
            $builder->setMaxResults($paginate->limit()->value());
        }
        return $builder;
    }
}
