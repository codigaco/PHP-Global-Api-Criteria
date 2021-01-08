<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Shared\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject\Value;

class ValueTest extends TestCase
{

    /** @test */
    public function value(): void
    {
        $this->assertEquals('null', Value::deserialize('null')->value());
        $this->assertEquals('name', Value::deserialize('name')->value());
        $this->assertEquals("'otherName'", Value::deserialize("'otherName'")->value());
        $this->assertEquals('5', Value::deserialize('5')->value());
        $this->assertEquals('5.5', Value::deserialize('5.5')->value());
        $this->assertEquals('false', Value::deserialize('false')->value());
        $this->assertEquals('true', Value::deserialize('true')->value());
    }

    /** @test */
    public function scalar(): void
    {
        $this->assertEquals(null, Value::deserialize('null')->scalar());
        $this->assertEquals('null', Value::deserialize("'null'")->scalar());

        $this->assertEquals('pet', Value::deserialize('pet')->scalar());
        $this->assertEquals('otherPet', Value::deserialize("'otherPet'")->scalar());

        $this->assertEquals(5, Value::deserialize('5')->scalar());
        $this->assertEquals('5', Value::deserialize("'5'")->scalar());

        $this->assertEquals(5.5, Value::deserialize('5.5')->scalar());
        $this->assertEquals('5.5', Value::deserialize("'5.5'")->scalar());

        $this->assertEquals(false, Value::deserialize('false')->scalar());
        $this->assertEquals('false', Value::deserialize("'false'")->scalar());

        $this->assertEquals(true, Value::deserialize('true')->scalar());
        $this->assertEquals('true', Value::deserialize("'true'")->scalar());

        $this->assertSame([1, 2, 3, 'whale', '5', 'dog'], Value::deserialize("1, 2,3,'whale','5', dog")->scalar());
    }

    /** @test */
    public function serialize(): void
    {
        $this->assertEquals('null', Value::deserialize('null')->serialize());
        $this->assertEquals('name', Value::deserialize('name')->serialize());
        $this->assertEquals("'otherName'", Value::deserialize("'otherName'")->serialize());
        $this->assertEquals('5', Value::deserialize('5')->serialize());
        $this->assertEquals('5.5', Value::deserialize('5.5')->serialize());
        $this->assertEquals('false', Value::deserialize('false')->serialize());
        $this->assertEquals('true', Value::deserialize('true')->serialize());
    }
}
