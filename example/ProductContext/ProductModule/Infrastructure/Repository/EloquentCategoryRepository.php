<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Application\Apply\EloquentApplyCriteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Application\Apply\EloquentApplyFilter;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\CategoryRepository;
use QuiqueGilB\GlobalApiCriteria\Example\SharedContext\SharedModule\Infrastructure\Eloquent\EloquentRepository;

class EloquentCategoryRepository extends EloquentRepository implements CategoryRepository
{
    public function querySearch(Criteria $criteria): array
    {
        $builder = self::createQueryBuilder($criteria);
        EloquentApplyCriteria::apply($builder, $criteria);
        return $this->castResult($builder->get()->all());
    }

    public function queryCount(Criteria $criteria): int
    {
        $builder = self::createQueryBuilder($criteria);
        EloquentApplyFilter::apply($builder, $criteria->filters());
        return $builder->count();
    }

    private static function createQueryBuilder(Criteria $criteria): Builder
    {
        return EloquentCategoryModel::query();
    }
}
