<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Application\Query\Category;

use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\CategoryRepository;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Data\Domain\ValueObject\QueryData;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject\QueryMetadata;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\QueryResponse\Domain\ValueObject\QueryResponse;

class SearchCategoryQueryHandler
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(SearchCategoryQuery $query): QueryResponse
    {
        $categories = $this->categoryRepository->querySearch($query->criteria());
        $countCategories = $this->categoryRepository->queryCount($query->criteria());

        return new QueryResponse(
            new QueryData($categories),
            new QueryMetadata(
                $query->criteria()->paginate()->offset()->value(),
                $query->criteria()->paginate()->limit()->value(),
                $countCategories
            )
        );
    }

}
