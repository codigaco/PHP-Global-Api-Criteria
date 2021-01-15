<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\QueryResponse\Metadata\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject\QueryMetadata;

class QueryMetadataTest extends TestCase
{
    /** @test */
    public function assert_calculate_items(): void
    {
        $metadata = new QueryMetadata(100, 20, 200);
        self::assertEquals(20, $metadata->items());

        $metadata = new QueryMetadata(190, 20, 200);
        self::assertEquals(10, $metadata->items());

        $metadata = new QueryMetadata(300, 20, 200);
        self::assertEquals(0, $metadata->items());

        $metadata = new QueryMetadata(300, 0, 200);
        self::assertEquals(0, $metadata->items());

        $metadata = new QueryMetadata(0, 20, 200);
        self::assertEquals(20, $metadata->items());

        $metadata = new QueryMetadata(0, 200, 20);
        self::assertEquals(20, $metadata->items());

        $metadata = new QueryMetadata(10, 0, 200);
        self::assertEquals(190, $metadata->items());
    }
}
