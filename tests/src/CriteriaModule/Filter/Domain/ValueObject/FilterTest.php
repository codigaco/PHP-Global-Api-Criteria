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
    public function assert_deserialize_equals(): void
    {
        $filter = Filter::deserialize("name = a_name");
        self::assertTrue($filter->operator()->isEqual());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());

        $filter = Filter::deserialize("name eq a_name");
        self::assertTrue($filter->operator()->isEqual());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());

        $filter = Filter::deserialize("name is a_name");
        self::assertTrue($filter->operator()->isEqual());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());
    }

    /** @test */
    public function assert_deserialize_not_equals(): void
    {
        $filter = Filter::deserialize("name != a_name");
        self::assertTrue($filter->operator()->isNotEqual());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());

        $filter = Filter::deserialize("name neq a_name");
        self::assertTrue($filter->operator()->isNotEqual());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());

        $filter = Filter::deserialize("name ne a_name");
        self::assertTrue($filter->operator()->isNotEqual());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());

        $filter = Filter::deserialize("name <> a_name");
        self::assertTrue($filter->operator()->isNotEqual());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());

        $filter = Filter::deserialize("name is not a_name");
        self::assertTrue($filter->operator()->isNotEqual());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());

        $filter = Filter::deserialize("name is    not a_name");
        self::assertTrue($filter->operator()->isNotEqual());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());
    }

    /** @test */
    public function assert_deserialize_greater(): void
    {
        $filter = Filter::deserialize("age > 21");
        self::assertTrue($filter->operator()->isGreater());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());

        $filter = Filter::deserialize("age gt 21");
        self::assertTrue($filter->operator()->isGreater());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());
    }

    /** @test */
    public function assert_deserialize_greater_or_equal(): void
    {
        $filter = Filter::deserialize("age >= 21");
        self::assertTrue($filter->operator()->isGreaterOrEqual());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());

        $filter = Filter::deserialize("age ge 21");
        self::assertTrue($filter->operator()->isGreaterOrEqual());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());

        $filter = Filter::deserialize("age gte 21");
        self::assertTrue($filter->operator()->isGreaterOrEqual());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());
    }

    /** @test */
    public function assert_deserialize_less(): void
    {
        $filter = Filter::deserialize("age < 21");
        self::assertTrue($filter->operator()->isLess());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());

        $filter = Filter::deserialize("age lt 21");
        self::assertTrue($filter->operator()->isLess());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());
    }

    /** @test */
    public function assert_deserialize_less_or_equal(): void
    {
        $filter = Filter::deserialize("age <= 21");
        self::assertTrue($filter->operator()->isLessOrEqual());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());

        $filter = Filter::deserialize("age le 21");
        self::assertTrue($filter->operator()->isLessOrEqual());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());

        $filter = Filter::deserialize("age lte 21");
        self::assertTrue($filter->operator()->isLessOrEqual());
        self::assertEquals('age', $filter->field()->value());
        self::assertEquals(21, $filter->value()->scalar());
    }

    /** @test */
    public function assert_deserialize_in(): void
    {
        $filter = Filter::deserialize("name in a_name, other_name");
        self::assertTrue($filter->operator()->isIn());
        self::assertEquals('name', $filter->field()->value());
        self::assertSame(['a_name','other_name'], $filter->value()->scalar());
    }

    /** @test */
    public function assert_deserialize_not_in(): void
    {
        $filter = Filter::deserialize("name not in a_name, other_name");
        self::assertTrue($filter->operator()->isNotIn());
        self::assertEquals('name', $filter->field()->value());
        self::assertSame(['a_name','other_name'], $filter->value()->scalar());
    }

    /** @test */
    public function assert_deserialize_like(): void
    {
        $filter = Filter::deserialize("name like a_name");
        self::assertTrue($filter->operator()->isLike());
        self::assertEquals('name', $filter->field()->value());
        self::assertEquals('a_name', $filter->value()->scalar());
    }

    /** @test */
    public function assert_deserialize_not_like(): void
    {
        $filter = Filter::deserialize("description not like a_description");
        self::assertTrue($filter->operator()->isNotLike());
        self::assertEquals('description', $filter->field()->value());
        self::assertEquals('a_description', $filter->value()->scalar());

        $filter = Filter::deserialize("description not   like a_description");
        self::assertTrue($filter->operator()->isNotLike());
        self::assertEquals('description', $filter->field()->value());
        self::assertEquals('a_description', $filter->value()->scalar());
    }

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
