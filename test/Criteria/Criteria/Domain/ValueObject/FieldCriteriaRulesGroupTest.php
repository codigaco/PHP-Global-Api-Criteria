<?php

namespace QuiqueGilB\GlobalApiCriteria\Test\Criteria\Criteria\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\Exception\FieldCriteriaRulesRepeatException;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\FieldCriteriaRules;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\FieldCriteriaRulesGroup;

class FieldCriteriaRulesGroupTest extends TestCase
{
    /** @test */
    public function assert_invalid_instances(): void
    {
        $this->expectException(FieldCriteriaRulesRepeatException::class);
        new FieldCriteriaRulesGroup(
            FieldCriteriaRules::create('id'),
            FieldCriteriaRules::create('name'),
            FieldCriteriaRules::create('email'),
            FieldCriteriaRules::create('name')
        );
    }

    /** @test */
    public function assert_valid_instance(): void
    {
        $this->expectNotToPerformAssertions();
        new FieldCriteriaRulesGroup(
            FieldCriteriaRules::create('id'),
            FieldCriteriaRules::create('name'),
            FieldCriteriaRules::create('email')
        );
    }

}
