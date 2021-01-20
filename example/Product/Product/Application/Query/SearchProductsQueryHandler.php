<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Application\Query;

use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Model\ProductRepository;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Data\Domain\ValueObject\QueryData;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject\QueryMetadata;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\QueryResponse\Domain\ValueObject\QueryResponse;

class SearchProductsQueryHandler
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(SearchProductsQuery $query): QueryResponse
    {
        $products = $this->productRepository->querySearch($query->criteria());
        $countProducts = $this->productRepository->queryCount($query->criteria());

        return new QueryResponse(
            new QueryData($products),
            new QueryMetadata(
                $query->criteria()->paginate()->offset()->value(),
                $query->criteria()->paginate()->limit()->value(),
                $countProducts
            )
        );
    }
}
