<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Application\Apply\EloquentApplyCriteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Application\Apply\EloquentApplyFilter;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\CategoryRepository;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\SharedModule\Infrastructure\Eloquent\EloquentRepository;

class EloquentCategoryRepository extends EloquentRepository implements CategoryRepository
{
    public function querySearch(Criteria $criteria): array
    {
        $builder = $this->createQueryBuilder($criteria);
        EloquentApplyCriteria::apply($builder, $criteria);
        return $this->castResult($builder->get()->all());
    }

    public function queryCount(Criteria $criteria): int
    {
        $builder = $this->createQueryBuilder($criteria);
        EloquentApplyFilter::apply($builder, $criteria->filters());
        return $builder->count();
    }

    private function createQueryBuilder(Criteria $criteria): Builder
    {
        return EloquentCategoryModel::query();
    }
}
