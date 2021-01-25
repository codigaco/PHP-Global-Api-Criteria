<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Application\Apply\DoctrineApplyCriteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Application\Apply\DoctrineApplyFilter;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\ProductRepository;

class DoctrineProductRepository extends EntityRepository implements ProductRepository
{
    public function querySearch(ProductCriteriaExample $productCriteria): array
    {
        $queryBuilder = $this->createBaseQueryBuilder($productCriteria);
        DoctrineApplyCriteria::apply($queryBuilder, $productCriteria, self::mapFields());

        return $queryBuilder->getQuery()->getResult();
    }

    public function queryCount(ProductCriteriaExample $productCriteria): int
    {
        $queryBuilder = $this->createBaseQueryBuilder($productCriteria)
            ->select('COUNT(product.id)');
        DoctrineApplyFilter::apply($queryBuilder, $productCriteria->filters(), self::mapFields());
        return $queryBuilder->getQuery()->getSingleScalarResult();
    }


    private function createBaseQueryBuilder(ProductCriteriaExample $productCriteria): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('product');
        return $queryBuilder;
    }

    private static function mapFields(): array
    {
        return [
            'name' => 'product.name',
            'price' => 'product.price'
        ];
    }
}
