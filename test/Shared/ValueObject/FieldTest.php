<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Shared\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Shared\Domain\Exception\InvalidFieldException;
use QuiqueGilB\GlobalApiCriteria\Shared\Domain\ValueObject\Field;

class FieldTest extends TestCase
{

    /** @test */
    public function validate(): void
    {
        $this->expectException(InvalidFieldException::class);
        new Field('');
    }

    /** @test */
    public function value(): void
    {
        $fieldName = 'person.name.firstName';
        $field = new Field($fieldName);

        self::assertEquals($fieldName, $field->value());
    }

    /** @test */
    public function has_field(): void
    {
        $field = new Field('location.coordinates.latitude');

        $this->assertTrue($field->has('location'));
        $this->assertTrue($field->has('location.coordinates'));
        $this->assertTrue($field->has('location.coordinates.latitude'));

        $this->assertFalse($field->has('coordinates.latitude'));
        $this->assertFalse($field->has('location.latitude'));
        $this->assertFalse($field->has('latitude'));
    }

}
