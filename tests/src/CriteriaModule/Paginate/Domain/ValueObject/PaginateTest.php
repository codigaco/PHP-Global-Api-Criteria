<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Paginate\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject\Limit;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject\Offset;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject\Paginate;

class PaginateTest extends TestCase
{
    /** @test */
    public function serialize(): void
    {
        self::assertEquals('0,0', Paginate::create()->serialize());
        self::assertEquals('5,10', Paginate::create(5, 10)->serialize());
        self::assertEquals('10,0', Paginate::create(10, 0)->serialize());
    }

    /** @test */
    public function deserialize(): void
    {
        $paginate = Paginate::deserialize('');
        self::assertEquals(0, $paginate->offset()->value());
        self::assertEquals(0, $paginate->limit()->value());

        $paginate = Paginate::deserialize('0,0');
        self::assertEquals(0, $paginate->offset()->value());
        self::assertEquals(0, $paginate->limit()->value());

        $paginate = Paginate::deserialize('10,5');
        self::assertEquals(10, $paginate->offset()->value());
        self::assertEquals(5, $paginate->limit()->value());

        $paginate = Paginate::deserialize('40, 20');
        self::assertEquals(40, $paginate->offset()->value());
        self::assertEquals(20, $paginate->limit()->value());

        $paginate = Paginate::deserialize('40');
        self::assertEquals(40, $paginate->offset()->value());
        self::assertEquals(0, $paginate->limit()->value());

    }

    /** @test */
    public function assert_unlimited(): void
    {
        $pagination = new Paginate();
        self::assertTrue($pagination->isUnlimited());

        $pagination = new Paginate(new Offset(5));
        self::assertFalse($pagination->isUnlimited());

        $pagination = new Paginate(null, new Limit(5));
        self::assertFalse($pagination->isUnlimited());

        self::assertTrue(Paginate::unlimited()->isUnlimited());
    }
}
