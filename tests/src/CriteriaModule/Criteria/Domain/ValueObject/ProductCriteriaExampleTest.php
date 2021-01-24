<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Criteria\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\Exception\FieldCriteriaRuleViolationException;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\Exception\InvalidFieldCriteriaRuleForAssertFieldException;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Order\Domain\ValueObject\OrderGroup;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;

class ProductCriteriaExampleTest extends TestCase
{
    /** @test */
    public function assert_invalid_field_criteria_order_rules(): void
    {
        $this->expectException(InvalidFieldCriteriaRuleForAssertFieldException::class);
        $criteria = ProductCriteriaExample::create();
        $criteria->withOrder(OrderGroup::deserialize('dimension'));
    }

    /** @test */
    public function assert_invalid_criteria_order_rules(): void
    {
        $this->expectException(FieldCriteriaRuleViolationException::class);
        $criteria = ProductCriteriaExample::create();
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
        $this->expectException(InvalidFieldCriteriaRuleForAssertFieldException::class);
        $criteria = ProductCriteriaExample::create();
        $criteria->withFilter(FilterGroup::deserialize('dimension eq 50'));
    }
    /** @test */
    public function assert_invalid_criteria_filter_rules(): void
    {
        $this->expectException(FieldCriteriaRuleViolationException::class);
        $criteria = ProductCriteriaExample::create();
        $criteria->withFilter(FilterGroup::deserialize('stock = 50'));
    }

    /** @test */
    public function assert_valid_criteria_filter_rules(): void
    {
        $this->expectNotToPerformAssertions();
        $criteria = ProductCriteriaExample::create();
        $criteria->withFilter(FilterGroup::deserialize('stock > 50 and stock < 100'));
    }

}
