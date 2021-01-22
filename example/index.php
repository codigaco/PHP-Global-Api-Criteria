<?php

use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Application\Query\SearchProductsQuery;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Application\Query\SearchProductsQueryHandler;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Criteria\ProductCriteriaExample;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Model\ProductRepository;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Infrastructure\Repository\EloquentProductRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$inputParams = getInputParams();

$productRepository = getRepository($inputParams['orm']);
$searchProductsQueryHandler = new SearchProductsQueryHandler($productRepository);

$criteria = ProductCriteriaExample::create()
    ->withFilter($inputParams['filter'])
    ->withOrder($inputParams['order'])
    ->withPaginate($inputParams['paginate']);

$query = new SearchProductsQuery($criteria);
$queryResponse = $searchProductsQueryHandler($query);

dump($queryResponse);

function getRepository(string $orm): ProductRepository
{
    if ('eloquent' === $orm) {
        require_once __DIR__ . '/Product/Shared/Infrastructure/Eloquent/configuration.php';
        return new EloquentProductRepository();
    }

    throw new RuntimeException('Not recognized orm');
}


function getInputParams(): array
{
    $defaultValues = [
        'orm' => 'eloquent',
        'filter' => null,
        'order' => null,
        'paginate' => null
    ];
    $options = getopt('', ['orm::', 'filter::', 'order::', 'paginate::']);

    return array_merge($defaultValues, $options);
}
