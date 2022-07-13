<?php

declare(strict_types=1);

namespace Forge\FormValidator\Tests;

use Forge\FormValidator\Tests\Support\RuleAttributeModel;
use Forge\FormValidator\Tests\Support\RuleModel;
use PHPUnit\Framework\TestCase;
use Yiisoft\Validator\SimpleRuleHandlerContainer;
use Yiisoft\Validator\Validator;

final class FormValidatorTest extends TestCase
{
    public function testValidateWithAttributes(): void
    {
        $formModel = new RuleAttributeModel();
        $validator = new Validator(new SimpleRuleHandlerContainer());

        $formModel->load(['RuleAttributeModel' => ['email' => '']]);
        $this->assertFalse($validator->validate($formModel)->isValid());
        $this->assertSame('Value cannot be blank.', $formModel->Error()->getFirst('email'));

        $formModel->load(['RuleAttributeModel' => ['email' => 'samdark']]);
        $this->assertTrue($validator->validate($formModel)->isValid());
        $this->assertsame('', $formModel->Error()->getFirst('email'));
    }

    public function testValidateWithRules(): void
    {
        $formModel = new RuleModel();
        $validator = new Validator(new SimpleRuleHandlerContainer());

        $formModel->load(['RuleModel' => ['email' => '']]);
        $this->assertFalse($validator->validate($formModel)->isValid());
        $this->assertSame('Value cannot be blank.', $formModel->Error()->getFirst('email'));

        $formModel->load(['RuleModel' => ['email' => 'samdark']]);
        $this->assertTrue($validator->validate($formModel)->isValid());
        $this->assertsame('', $formModel->Error()->getFirst('email'));
    }
}
