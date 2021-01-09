<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\QueryResponse\Domain\Metadata\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject\QueryMetadata;

class QueryMetadataTest extends TestCase
{
    /** @test */
    public function assert_calculate_items()
    {
        $metadata = new QueryMetadata(100, 20, 200);
        self::assertEquals(20, $metadata->items());

        $metadata = new QueryMetadata(190, 20, 200);
        self::assertEquals(10, $metadata->items());

        $metadata = new QueryMetadata(300, 20, 200);
        self::assertEquals(0, $metadata->items());

    }
}
