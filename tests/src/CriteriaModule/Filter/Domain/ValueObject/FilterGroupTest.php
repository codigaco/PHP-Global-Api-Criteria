<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Filter\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\ComparisonOperator;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Field\Domain\ValueObject\Field;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Value\Domain\ValueObject\Value;

class FilterGroupTest extends TestCase
{
    /** @test */
    public function assert_has_only_one(): void
    {
        self::assertTrue(FilterGroup::deserialize('a = b')->hasOnlyOne());
        self::assertFalse(FilterGroup::deserialize('a = b and c = d')->hasOnlyOne());
    }

    /** @test */
    public function serialize(): void
    {
        $filterText = "priority = true or (stock gt 1000 or (price > 50 and price < 100) and name != null and (city in Madrid, Valencia, 'New York' or city like bee))";
        $rootFilterGroup = FilterGroup::deserialize($filterText);

        self::assertEquals($filterText, $rootFilterGroup->serialize());
    }

    /** @test */
    public function deserialize(): void
    {
        $filterText = "priority = true OR (stock gt 1000 || (price > 50 and price < 100) AND name != null && (city in Madrid, Valencia, 'New York' or city like bee))";
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
        $filterText = "priority = false or (stock gt 1000 or (price > 50 and price < 100) and name != null and (city in Madrid, Valencia, 'New York' or city like bee))";

        $filterGroup = FilterGroup::create()
            ->and(new Filter(new Field('priority'), new ComparisonOperator('='), new Value('false')))
            ->or(FilterGroup::create()
                ->and(new Filter(new Field('stock'), new ComparisonOperator('gt'), new Value('1000')))
                ->or(FilterGroup::create()
                    ->and(new Filter(new Field('price'), new ComparisonOperator('>'), new Value('50')))
                    ->and(new Filter(new Field('price'), new ComparisonOperator('<'), new Value('100')))
                )
                ->and(new Filter(new Field('name'), new ComparisonOperator('!='), new Value('null')))
                ->and(FilterGroup::create()
                    ->and(new Filter(new Field('city'),
                        new ComparisonOperator('in'),
                        new Value("Madrid, Valencia, 'New York'")))
                    ->or(new Filter(new Field('city'), new ComparisonOperator('like'), new Value('bee')))
                )
            );

        self::assertEquals($filterText, $filterGroup->serialize());
    }
}
