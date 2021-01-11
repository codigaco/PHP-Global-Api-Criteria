<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Shared\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Shared\Field\Domain\Exception\InvalidFieldException;
use QuiqueGilB\GlobalApiCriteria\Shared\Field\Domain\ValueObject\Field;

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
        $field = new Field('location.coordinates');

        self::assertTrue($field->has('location'));
        self::assertTrue($field->has('location.coordinates'));
        self::assertTrue($field->has('location.coordinates.latitude'));

        self::assertFalse($field->has('coordinates'));
        self::assertFalse($field->has('location.latitude'));
        self::assertFalse($field->has('latitude'));

        self::assertFalse($field->has('locat'));
        self::assertFalse($field->has('location.coord'));
    }

}
