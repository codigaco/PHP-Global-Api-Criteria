<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Application\Query\Product;

use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\ProductRepository;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\Data\Domain\ValueObject\QueryData;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\Metadata\Domain\ValueObject\QueryMetadata;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\QueryResponse\Domain\ValueObject\QueryResponse;

class SearchProductByIdQueryHandler
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(SearchProductByIdQuery $query): QueryResponse
    {
        $criteria = ProductCriteriaExample::create()
            ->withFilter('id = ' . $query->productId());

        $products = $this->productRepository->querySearch($criteria);
        $countProducts = $this->productRepository->queryCount($criteria);

        return new QueryResponse(
            new QueryData($products),
            new QueryMetadata(
                $criteria->paginate()->offset()->value(),
                $criteria->paginate()->limit()->value(),
                $countProducts
            )
        );
    }
}
