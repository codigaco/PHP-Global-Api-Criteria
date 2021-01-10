<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\QueryResponse\Data\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Data\Domain\ValueObject\QueryData;
use stdClass;

class QueryDataTest extends TestCase
{
    /** @test */
    public function assert_value(): void
    {
        self::assertEquals(null, QueryData::create(null)->value());
        self::assertEquals('abc', QueryData::create('abc')->value());
        self::assertEquals(555, QueryData::create(555)->value());
        self::assertSame([], QueryData::create([])->value());
        self::assertSame(['a', 'b'], QueryData::create(['a', 'b'])->value());
    }

    /** @test */
    public function assert_types(): void
    {
        self::assertTrue(QueryData::create(null)->isNull());

        self::assertTrue(QueryData::create([])->isCollection());
        self::assertTrue(QueryData::create(['a', 'b', 'c'])->isCollection());
        self::assertTrue(QueryData::create([['name' => 'Enrique']])->isCollection());

        self::assertTrue(QueryData::create('my_value')->isElement());
        self::assertTrue(QueryData::create(0)->isElement());
        self::assertTrue(QueryData::create(555)->isElement());
        self::assertTrue(QueryData::create(['name' => 'Enrique', 'age' => 25])->isElement());
        self::assertTrue(QueryData::create((object)['name' => 'Enrique', 'age' => 25])->isElement());
        self::assertTrue(QueryData::create(new stdClass())->isElement());
    }
}
