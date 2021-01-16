<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\Criteria\Paginate\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\Exception\InvalidOffsetException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Offset;

class OffsetTest extends TestCase
{
    /** @test */
    public function invalid_instances(): void
    {
        $this->expectException(InvalidOffsetException::class);
        new Offset(-5);
    }

    /** @test */
    public function valid_instances(): void
    {
        $offset = new Offset(0);
        self::assertEquals(0, $offset->value());
        self::assertTrue($offset->isZero());

        $offset = new Offset(50);
        self::assertEquals(50, $offset->value());
        self::assertFalse($offset->isZero());
    }
}
