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

        $formModel->setValue('email', '');
        $this->assertFalse($validator->validate($formModel)->isValid());

        $formModel->setValue('email', 'samdark');
        $this->assertTrue($validator->validate($formModel)->isValid());
    }

    public function testValidateWithRules(): void
    {
        $formModel = new RuleModel();
        $validator = new Validator(new SimpleRuleHandlerContainer());

        $formModel->setValue('email', '');
        $this->assertFalse($validator->validate($formModel)->isValid());

        $formModel->setValue('email', 'samdark');
        $this->assertTrue($validator->validate($formModel)->isValid());
    }
}
