<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Filter\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\ComparisonOperator;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\Filter;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Field\Domain\ValueObject\Field;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Value\Domain\ValueObject\Value;

class FilterTest extends TestCase
{
    /** @test */
    public function serialize(): void
    {
        $filterText = 'name = "Marta"';
        self::assertEquals($filterText, Filter::deserialize($filterText)->serialize());

        $filterText = 'name = Marta';
        self::assertEquals($filterText, Filter::deserialize($filterText)->serialize());

        $filterText = 'age = 5';
        self::assertEquals($filterText, Filter::deserialize($filterText)->serialize());

        $filterText = 'age = "5"';
        self::assertEquals($filterText, Filter::deserialize($filterText)->serialize());

        $filter = new Filter(new Field('name'), new ComparisonOperator('eq'), new Value('Pedro'));
        self::assertEquals('name eq Pedro', $filter->serialize());

        $filter = new Filter(new Field('hasCar'), new ComparisonOperator('eq'), new Value('true'));
        self::assertEquals('hasCar eq true', $filter->serialize());

        $filter = new Filter(new Field('address.city'), new ComparisonOperator('in'), new Value('Valencia, Madrid, Barcelona'));
        self::assertEquals('address.city in Valencia, Madrid, Barcelona', $filter->serialize());

    }

    /** @test */
    public function deserialize(): void
    {
        $filter = Filter::deserialize('name = Enrique');
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('Enrique', $filter->value()->value());
        self::assertEquals('Enrique', $filter->value()->scalar());
        self::assertEquals('=', $filter->operator()->value());

        $filter = Filter::deserialize('country NE "Spain"');
        self::assertEquals('country', $filter->field()->value());
        self::assertEquals('"Spain"', $filter->value()->value());
        self::assertEquals('Spain', $filter->value()->scalar());
        self::assertEquals('ne', $filter->operator()->value());

        $filter = Filter::deserialize('age > 25');
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals('25', $filter->value()->value());
        self::assertEquals(25, $filter->value()->scalar());
        self::assertEquals('>', $filter->operator()->value());

        $filter = Filter::deserialize('hasWork eq true');
        self::assertEquals('hasWork', $filter->field()->value());
        self::assertEquals('true', $filter->value()->value());
        self::assertEquals(true, $filter->value()->scalar());
        self::assertEquals('eq', $filter->operator()->value());

        $filter = Filter::deserialize('country in spain, 222, germany');
        self::assertEquals('country', $filter->field()->value());
        self::assertEquals('spain, 222, germany', $filter->value()->value());
        self::assertSame(['spain', 222, 'germany'], $filter->value()->scalar());
        self::assertEquals('in', $filter->operator()->value());
    }
}
