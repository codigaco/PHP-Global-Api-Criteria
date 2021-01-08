<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Criteria\Filter\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;

class FilterGroupTest extends TestCase
{
    /** @test */
    public function serialize(): void
    {

    }

    /** @test */
    public function deserialize(): void
    {
        $filterText = "priority = true or (stock gt 1000 or (price > 50 and price < 100) and name != null and (city in Madrid, Valencia, 'New York' or city like bee))";
        $rootFilterGroup = FilterGroup::deserialize($filterText);

        /** @var $filter Filter|FilterGroup */

        // priority = true
        $filter = $rootFilterGroup->get(0);
        self::assertInstanceOf(Filter::class, $filter);
        self::assertTrue($filter->logicalOperator()->isAnd());
        self::assertEquals('priority', $filter->field()->value());
        self::assertEquals('=', $filter->operator()->value());
        self::assertEquals(true, $filter->value()->scalar());

        // || (stock gt 1000 or (price > 50 && price < 100) AND name != null and (city in Madrid, Valencia, 'New York' or city like bee))
        $filter = $rootFilterGroup->get(1);
        self::assertInstanceOf(FilterGroup::class, $filter);
        self::assertTrue($filter->logicalOperator()->isOr());

        // stock gt 1000
        $filter = $rootFilterGroup->get(1)->get(0);
        self::assertInstanceOf(Filter::class, $filter);
        self::assertTrue($filter->logicalOperator()->isAnd());
        self::assertEquals('stock', $filter->field()->value());
        self::assertEquals('gt', $filter->operator()->value());
        self::assertEquals(1000, $filter->value()->scalar());

        // or (price > 50 and price < 100)
        $filter = $rootFilterGroup->get(1)->get(1);
        self::assertInstanceOf(FilterGroup::class, $filter);
        self::assertTrue($filter->logicalOperator()->isOr());

        // price > 50
        $filter = $rootFilterGroup->get(1)->get(1)->get(0);
        self::assertInstanceOf(Filter::class, $filter);
        self::assertTrue($filter->logicalOperator()->isAnd());
        self::assertEquals('price', $filter->field()->value());
        self::assertEquals('>', $filter->operator()->value());
        self::assertEquals(50, $filter->value()->scalar());

        // and price < 100
        $filter = $rootFilterGroup->get(1)->get(1)->get(1);
        self::assertInstanceOf(Filter::class, $filter);
        self::assertTrue($filter->logicalOperator()->isAnd());
        self::assertEquals('price', $filter->field()->value());
        self::assertEquals('<', $filter->operator()->value());
        self::assertEquals(100, $filter->value()->scalar());

        // and name != null
        $filter = $rootFilterGroup->get(1)->get(2);
        self::assertInstanceOf(Filter::class, $filter);
        self::assertTrue($filter->logicalOperator()->isAnd());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('!=', $filter->operator()->value());
        self::assertEquals(null, $filter->value()->scalar());

        // and (city in Madrid, Valencia, 'New York' or city like bee)
        $filter = $rootFilterGroup->get(1)->get(3);
        self::assertInstanceOf(FilterGroup::class, $filter);
        self::assertTrue($filter->logicalOperator()->isAnd());

        // city in Madrid, Valencia, 'New York'
        $filter = $rootFilterGroup->get(1)->get(3)->get(0);
        self::assertInstanceOf(Filter::class, $filter);
        self::assertTrue($filter->logicalOperator()->isAnd());
        self::assertEquals('city', $filter->field()->value());
        self::assertEquals('in', $filter->operator()->value());
        self::assertSame(['Madrid', 'Valencia', 'New York'], $filter->value()->scalar());

        // or city like bee
        $filter = $rootFilterGroup->get(1)->get(3)->get(1);
        self::assertInstanceOf(Filter::class, $filter);
        self::assertTrue($filter->logicalOperator()->isOr());
        self::assertEquals('city', $filter->field()->value());
        self::assertEquals('like', $filter->operator()->value());
        self::assertEquals('bee', $filter->value()->scalar());


    }

    /** @test */
    public function building(): void
    {

    }

}
