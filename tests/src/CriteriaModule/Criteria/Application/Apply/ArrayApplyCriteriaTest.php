<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Criteria\Application\Apply;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Application\Apply\ArrayApplyCriteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject\Paginate;

class ArrayApplyCriteriaTest extends TestCase
{
    private function storage(): array
    {
        return json_decode(file_get_contents(__DIR__ . "/storage.json"), true);
    }

    /** @test */
    public function filter(): void
    {
        $arrayFiltered = ArrayApplyCriteria::apply(
            $this->storage(),
            Criteria::create()
                ->withFilter(FilterGroup::deserialize('(name = Jimmie Petty or name = Luna Mccall) and registered >= 2014'))
                ->withOrder(OrderGroup::deserialize('name asc'))
                ->withPaginate(Paginate::create(0, 2))
        );

        self::assertCount(2, $arrayFiltered);
        self::assertEquals('Jimmie Petty', $arrayFiltered[0]['name']);
        self::assertEquals('Luna Mccall', $arrayFiltered[1]['name']);
    }

}
