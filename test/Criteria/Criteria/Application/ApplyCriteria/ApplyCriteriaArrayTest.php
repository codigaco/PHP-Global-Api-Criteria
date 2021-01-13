<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Criteria\Criteria\Application\ApplyCriteria;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Application\ApplyCriteria\ApplyCriteriaArray;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Paginate;

class ApplyCriteriaArrayTest extends TestCase
{
    private $storage = [];

    protected function setUp(): void
    {
        $this->storage[] = [
            'name' => 'Pedro',
            'lastName' => 'Garcia',
            'birthday' => '2000-09-14',
            'city' => 'Madrid'
        ];
        $this->storage[] = [
            'name' => 'Marta',
            'lastName' => 'Lopez',
            'birthday' => '1991-09-14',
            'city' => 'Francia'
        ];
        $this->storage[] = [
            'name' => 'Laura',
            'lastName' => 'Boix',
            'birthday' => '1965-12-11',
            'city' => 'Valencia'
        ];
        $this->storage[] = [
            'name' => 'Ramon',
            'lastName' => 'Matoses',
            'birthday' => '1975-01-12',
            'city' => 'Barcelona'
        ];
        $this->storage[] = [
            'name' => 'Enrique',
            'lastName' => 'Gil',
            'birthday' => '1995-09-14',
            'city' => 'Valencia'
        ];
    }

    private function storage(): array
    {
        return unserialize(serialize($this->storage));
    }

    /** @test */
    public function filter(): void
    {

        $arrayFiltered = ApplyCriteriaArray::apply(
            Criteria::create()
                ->withFilter(FilterGroup::deserialize('(name = Enrique or name = Ramon) and birthday >= 1950'))
                ->withOrder(OrderGroup::deserialize('name asc'))
                ->withPaginate(Paginate::create(0, 2)),
            $this->storage()
        );

        self::assertCount(2, $arrayFiltered);
        self::assertEquals('Enrique', $arrayFiltered[0]['name']);
        self::assertEquals('Ramon', $arrayFiltered[1]['name']);
    }
}
