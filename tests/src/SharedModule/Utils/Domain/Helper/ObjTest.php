<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\SharedModule\Utils\Domain\Helper;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Utils\Domain\Exception\KeyNotDefinedException;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Utils\Domain\Helper\Obj;
use QuiqueGilB\GlobalApiCriteria\SharedModule\Value\Domain\ValueObject\Value;
use TypeError;

class ObjTest extends TestCase
{
    /** @test */
    public function get_property_array(): void
    {
        $arr = [
            'name' => 'Enrique',
            'address' => [
                'city' => 'Valencia'
            ]
        ];

        self::assertEquals('Enrique', Obj::get($arr, 'name'));
        self::assertEquals('Valencia', Obj::get($arr, 'address.city'));
    }

    /** @test */
    public function get_property_stdClass(): void
    {
        $arr = (object)[
            'name' => 'Enrique',
            'address' => (object)[
                'city' => 'Valencia'
            ]
        ];

        self::assertEquals('Enrique', Obj::get($arr, 'name'));
        self::assertEquals('Valencia', Obj::get($arr, 'address.city'));
    }

    /** @test */
    public function get_property_object(): void
    {
        $obj = new Value("Enrique");

        self::assertEquals('Enrique', Obj::get($obj, 'value'));
        self::assertEquals('string', Obj::get($obj, 'type.value'));
    }

    /** @test */
    public function assert_null_if_key_not_exists(): void
    {
        self::assertNull(Obj::getOrNull([], 'email'));
    }

    /** @test */
    public function invalid_get_property_object(): void
    {
        $this->expectException(TypeError::class);
        self::assertEquals('Enrique', Obj::get("my value", 'value'));
    }

    /** @test */
    public function assert_key_not_defined(): void
    {
        $this->expectException(KeyNotDefinedException::class);
        Obj::get(['name' => 'Enrique'], 'email');
    }
}
