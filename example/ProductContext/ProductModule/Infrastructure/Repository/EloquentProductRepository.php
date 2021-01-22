<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Application\Apply\EloquentApplyCriteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Application\Apply\EloquentApplyFilter;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\ProductRepository;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\SharedModule\Infrastructure\Eloquent\EloquentRepository;

class EloquentProductRepository extends EloquentRepository implements ProductRepository
{

    public function querySearch(ProductCriteriaExample $productCriteria): array
    {
        $builder = $this->createQueryBuilder($productCriteria);
        EloquentApplyCriteria::apply($builder, $productCriteria);
        return $this->castResult($builder->get()->all());
    }

    public function queryCount(ProductCriteriaExample $productCriteria): int
    {
        $builder = $this->createQueryBuilder($productCriteria);
        EloquentApplyFilter::apply($builder, $productCriteria->filters());
        return $builder->count();
    }

    private function createQueryBuilder(ProductCriteriaExample $productCriteria): Builder
    {
        $builder = EloquentProductModel::query();

        if ($productCriteria->hasField('category')) {
            $builder->with('category');
        }

        return $builder;
    }
}
