<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\Criteria\Filter\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\Exception\InvalidLogicalOperatorException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\LogicalOperator;

class LogicalOperatorTest extends TestCase
{
    /** @test */
    public function invalid_instances(): void
    {
        $this->expectException(InvalidLogicalOperatorException::class);
        LogicalOperator::create('fakeOperator');
    }

    /** @test */
    public function valid_instances(): void
    {
        self::assertTrue(LogicalOperator::create('or')->isOr());
        self::assertTrue(LogicalOperator::create('OR')->isOr());
        self::assertTrue(LogicalOperator::create('||')->isOr());

        self::assertTrue(LogicalOperator::create('and')->isAnd());
        self::assertTrue(LogicalOperator::create('AND')->isAnd());
        self::assertTrue(LogicalOperator::create('&&')->isAnd());
    }

}
