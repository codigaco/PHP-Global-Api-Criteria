<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\Criteria\Criteria\Application\ApplyCriteria;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Application\ApplyCriteria\ApplyCriteriaArray;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;

class ApplyCriteriaArrayTest extends TestCase
{
    private function storage(): array
    {
        return json_decode(file_get_contents(__DIR__ . "/storage.json"), true);
    }

    /** @test */
    public function filter(): void
    {
        $arrayFiltered = ApplyCriteriaArray::apply(
            Criteria::create()
                ->withFilter(FilterGroup::deserialize('(name = Jimmie Petty or name = Luna Mccall) and registered >= 2014'))
                ->withOrder(OrderGroup::deserialize('name asc'))
                ->withPaginate(Paginate::create(0, 2)),
            $this->storage()
        );

        self::assertCount(2, $arrayFiltered);
        self::assertEquals('Jimmie Petty', $arrayFiltered[0]['name']);
        self::assertEquals('Luna Mccall', $arrayFiltered[1]['name']);
    }

}
