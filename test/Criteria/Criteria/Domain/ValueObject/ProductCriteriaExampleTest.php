<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Criteria\Criteria\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\Exception\FieldCriteriaRuleViolationException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\Exception\InvalidFieldCriteriaRuleForAssertFieldException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Criteria\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Criteria\ProductCriteriaExample;

class ProductCriteriaExampleTest extends TestCase
{
    /** @test */
    public function assert_invalid_field_criteria_order_rules(): void
    {
        $criteria = ProductCriteriaExample::create();
        $this->expectException(InvalidFieldCriteriaRuleForAssertFieldException::class);
        $criteria->withOrder(OrderGroup::deserialize('dimension'));
    }

    /** @test */
    public function assert_invalid_criteria_order_rules(): void
    {
        $criteria = ProductCriteriaExample::create();
        $this->expectException(FieldCriteriaRuleViolationException::class);
        $criteria->withOrder(OrderGroup::deserialize('id'));
    }

    /** @test */
    public function assert_valid_criteria_order_rules(): void
    {
        $criteria = ProductCriteriaExample::create();
        $this->expectNotToPerformAssertions();
        $criteria->withOrder(OrderGroup::deserialize('name'));
    }

    /** @test */
    public function assert_invalid_field_criteria_filter_rules(): void
    {
        $criteria = ProductCriteriaExample::create();
        $this->expectException(InvalidFieldCriteriaRuleForAssertFieldException::class);
        $criteria->withFilter(FilterGroup::deserialize('dimension eq 50'));
    }
    /** @test */
    public function assert_invalid_criteria_filter_rules(): void
    {
        $criteria = ProductCriteriaExample::create();
        $this->expectException(FieldCriteriaRuleViolationException::class);
        $criteria->withFilter(FilterGroup::deserialize('stock = 50'));
    }

    /** @test */
    public function assert_valid_criteria_filter_rules(): void
    {
        $criteria = ProductCriteriaExample::create();
        $this->expectNotToPerformAssertions();
        $criteria->withFilter(FilterGroup::deserialize('stock > 50 and stock < 100'));
    }

}
