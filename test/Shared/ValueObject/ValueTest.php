<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Shared\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject\Value;

class ValueTest extends TestCase
{
    /** @test */
    public function value(): void
    {
        self::assertEquals('null', Value::deserialize('null')->value());
        self::assertEquals('name', Value::deserialize('name')->value());
        self::assertEquals("'otherName'", Value::deserialize("'otherName'")->value());
        self::assertEquals('5', Value::deserialize('5')->value());
        self::assertEquals('5.5', Value::deserialize('5.5')->value());
        self::assertEquals('false', Value::deserialize('false')->value());
        self::assertEquals('true', Value::deserialize('true')->value());
    }

    /** @test */
    public function scalar(): void
    {
        self::assertEquals(null, Value::deserialize('null')->scalar());
        self::assertEquals('null', Value::deserialize("'null'")->scalar());

        self::assertEquals('pet', Value::deserialize('pet')->scalar());
        self::assertEquals('otherCat', Value::deserialize("'otherCat'")->scalar());

        self::assertEquals(5, Value::deserialize('5')->scalar());
        self::assertEquals('5', Value::deserialize("'5'")->scalar());

        self::assertEquals(5.5, Value::deserialize('5.5')->scalar());
        self::assertEquals('5.5', Value::deserialize("'5.5'")->scalar());

        self::assertEquals(false, Value::deserialize('false')->scalar());
        self::assertEquals('false', Value::deserialize("'false'")->scalar());

        self::assertEquals(true, Value::deserialize('true')->scalar());
        self::assertEquals('true', Value::deserialize("'true'")->scalar());

        self::assertSame([1, 2, 3, 'whale', '5', 'dog'], Value::deserialize("1, 2,3,'whale','5', dog")->scalar());
    }

    /** @test */
    public function serialize(): void
    {
        self::assertEquals('null', Value::deserialize('null')->serialize());
        self::assertEquals('name', Value::deserialize('name')->serialize());
        self::assertEquals("'otherPet'", Value::deserialize("'otherPet'")->serialize());
        self::assertEquals('5', Value::deserialize('5')->serialize());
        self::assertEquals('5.5', Value::deserialize('5.5')->serialize());
        self::assertEquals('false', Value::deserialize('false')->serialize());
        self::assertEquals('true', Value::deserialize('true')->serialize());
    }
}
