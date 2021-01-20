<?php

use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Application\Query\SearchProductsQuery;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Application\Query\SearchProductsQueryHandler;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Criteria\ProductCriteriaExample;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Infrastructure\Repository\EloquentProductRepository;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Product/Shared/Infrastructure/Eloquent/configuration.php';

$searchProductsQueryHandler = new SearchProductsQueryHandler(new EloquentProductRepository());

$criteria = ProductCriteriaExample::create()
    ->withFilter(FilterGroup::deserialize('stock > 500'))
    ->withPaginate(Paginate::create(1, 2));

$query = new SearchProductsQuery($criteria);
$queryResponse = $searchProductsQueryHandler($query);

dump($queryResponse);

