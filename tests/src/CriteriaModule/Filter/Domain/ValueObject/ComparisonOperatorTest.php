<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Filter\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\Exception\InvalidComparisonOperatorException;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\ComparisonOperator;

class ComparisonOperatorTest extends TestCase
{
    /** @test */
    public function invalid_instances(): void
    {
        $this->expectException(InvalidComparisonOperatorException::class);
        ComparisonOperator::create('fakeOperator');
    }

    /** @test */
    public function valid_instances(): void
    {
        self::assertTrue(ComparisonOperator::create("=")->isEqual());
        self::assertTrue(ComparisonOperator::create("eq")->isEqual());
        self::assertTrue(ComparisonOperator::create("EQ")->isEqual());
        self::assertTrue(ComparisonOperator::create("IS")->isEqual());

        self::assertTrue(ComparisonOperator::create("!=")->isNotEqual());
        self::assertTrue(ComparisonOperator::create("<>")->isNotEqual());
        self::assertTrue(ComparisonOperator::create("ne")->isNotEqual());
        self::assertTrue(ComparisonOperator::create("NE")->isNotEqual());

        self::assertTrue(ComparisonOperator::create("gt")->isGreater());
        self::assertTrue(ComparisonOperator::create("GT")->isGreater());
        self::assertTrue(ComparisonOperator::create(">")->isGreater());

        self::assertTrue(ComparisonOperator::create(">=")->isGreaterOrEqual());
        self::assertTrue(ComparisonOperator::create("ge")->isGreaterOrEqual());
        self::assertTrue(ComparisonOperator::create("GE")->isGreaterOrEqual());
        self::assertTrue(ComparisonOperator::create("gte")->isGreaterOrEqual());
        self::assertTrue(ComparisonOperator::create("GTE")->isGreaterOrEqual());

        self::assertTrue(ComparisonOperator::create("<")->isLess());
        self::assertTrue(ComparisonOperator::create("lt")->isLess());
        self::assertTrue(ComparisonOperator::create("LT")->isLess());

        self::assertTrue(ComparisonOperator::create("=<")->isLessOrEqual());
        self::assertTrue(ComparisonOperator::create("le")->isLessOrEqual());
        self::assertTrue(ComparisonOperator::create("LE")->isLessOrEqual());
        self::assertTrue(ComparisonOperator::create("lte")->isLessOrEqual());
        self::assertTrue(ComparisonOperator::create("LTE")->isLessOrEqual());

        self::assertTrue(ComparisonOperator::create("in")->isIn());
        self::assertTrue(ComparisonOperator::create("IN")->isIn());

        self::assertTrue(ComparisonOperator::create("like")->isLike());
        self::assertTrue(ComparisonOperator::create("LIKE")->isLike());
        self::assertTrue(ComparisonOperator::create("contains")->isLike());
        self::assertTrue(ComparisonOperator::create("CONTAINS")->isLike());
    }
}
