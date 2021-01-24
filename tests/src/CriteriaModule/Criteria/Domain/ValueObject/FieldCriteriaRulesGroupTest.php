<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Criteria\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\Exception\FieldCriteriaRulesRepeatException;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\FieldCriteriaRules;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\FieldCriteriaRulesGroup;

class FieldCriteriaRulesGroupTest extends TestCase
{
    /** @test */
    public function assert_invalid_instances(): void
    {
        $this->expectException(FieldCriteriaRulesRepeatException::class);
        $this->expectExceptionMessage('name, email');

        new FieldCriteriaRulesGroup(
            FieldCriteriaRules::create('id'),
            FieldCriteriaRules::create('name'),
            FieldCriteriaRules::create('email'),
            FieldCriteriaRules::create('name'),
            FieldCriteriaRules::create('lastname'),
            FieldCriteriaRules::create('email'),
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
