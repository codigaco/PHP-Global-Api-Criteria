<?php

use QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\Factory\FilterGroupFactory;
use QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject\ComparisonOperator;
use QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Shared\Shared\Domain\ValueObject\Field;

require_once 'vendor/autoload.php';

$uriFilter = "name eq 'Milk'";
$uriFilter = "price lt 2.55 and ((name eq 'Milk' or name eq 'Eggs') and (city in 'Madrid', 'Valencia')) or price gt 50";
$uriOrder = '';
$usiPaginate = '';

[$field, $operator, $value] = explode(' ', $uriFilter);

$filter = new Filter(new Field($field), new ComparisonOperator($operator), $value);
$filterGroup = FilterGroup::create($filter);



FilterGroupFactory::fromString($uriFilter);

//var_dump();
//die;
