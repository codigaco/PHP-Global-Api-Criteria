<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\Shared\Utils\Domain\Helper;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Shared\Utils\Domain\Helper\Obj;
use QuiqueGilB\GlobalApiCriteria\Shared\Value\Domain\ValueObject\Value;
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
        self::assertNull(Obj::get($arr, 'email'));
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
        self::assertNull(Obj::get($arr, 'email'));
    }

    /** @test */
    public function get_property_object(): void
    {
        $obj = new Value("Enrique");

        self::assertEquals('Enrique', Obj::get($obj, 'value'));
        self::assertEquals('string', Obj::get($obj, 'type.value'));
        self::assertNull(Obj::get($obj, 'email'));
    }

    /** @test */
    public function invalid_get_property_object(): void
    {
        $this->expectException(TypeError::class);
        self::assertEquals('Enrique', Obj::get("my value", 'value'));
    }

}
