<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\Criteria\Paginate\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\Exception\InvalidLimitException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Paginate\Domain\ValueObject\Limit;

class LimitTest extends TestCase
{
    /** @test */
    public function invalid_instances(): void
    {
        $this->expectException(InvalidLimitException::class);
        new Limit(-5);
    }

    /** @test */
    public function valid_instances(): void
    {
        $limit = new Limit(0);
        self::assertEquals(0, $limit->value());
        self::assertTrue($limit->isZero());

        $limit = new Limit(50);
        self::assertEquals(50, $limit->value());
        self::assertFalse($limit->isZero());
    }
}
