<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Shared\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Shared\Value\Domain\Exception\InvalidValueTypeException;
use QuiqueGilB\GlobalApiCriteria\Shared\Value\Domain\ValueObject\ValueType;

class ValueTypeTest extends TestCase
{
    /** @test */
    public function invalid_instances(): void
    {
        $this->expectException(InvalidValueTypeException::class);
        new ValueType('aType');
    }

    /** @test */
    public function assert_types(): void
    {
        self::assertTrue((new ValueType('string'))->isString());
        self::assertTrue((new ValueType('null'))->isNull());
        self::assertTrue((new ValueType('boolean'))->isBoolean());
        self::assertTrue((new ValueType('int'))->isInt());
        self::assertTrue((new ValueType('int'))->isNumber());
        self::assertTrue((new ValueType('decimal'))->isDecimal());
        self::assertTrue((new ValueType('decimal'))->isNumber());
        self::assertTrue((new ValueType('array'))->isArray());
    }

    public function assert_from_value(): void
    {
        self::assertTrue(ValueType::fromValue('abc')->isString());
        self::assertTrue(ValueType::fromValue('null')->isNull());
        self::assertTrue(ValueType::fromValue('false')->isBoolean());
        self::assertTrue(ValueType::fromValue('true')->isBoolean());
        self::assertTrue(ValueType::fromValue('1234')->isInt());
        self::assertTrue(ValueType::fromValue('1234')->isNumber());
        self::assertTrue(ValueType::fromValue('123.4')->isDecimal());
        self::assertTrue(ValueType::fromValue('123.4')->isNumber());
        self::assertTrue(ValueType::fromValue('1, 2, abc, false')->isArray());
    }
}
