<?php

declare(strict_types=1);

namespace Forge\FormValidator\Tests;

use Forge\FormValidator\FormValidator;
use Forge\FormValidator\Tests\Support\RuleAttributeModel;
use Forge\FormValidator\Tests\Support\RuleModel;
use Forge\FormValidator\Tests\Support\TranslatorModel;
use Forge\TestUtils\Assert;
use PHPUnit\Framework\TestCase;
use Yiisoft\Validator\SimpleRuleHandlerContainer;
use Yiisoft\Validator\Validator;

final class FormValidatorTest extends TestCase
{
    public function testGetRules(): void
    {
        $formModel = new class () extends FormValidator {
        };

        $this->assertSame([], $formModel->getRules());
    }

    public function testValidateWithAttributes(): void
    {
        $formModel = new RuleAttributeModel();
        $validator = new Validator(new SimpleRuleHandlerContainer());

        $formModel->load(['RuleAttributeModel' => ['required' => '']]);
        $this->assertFalse($validator->validate($formModel)->isValid());
        $this->assertSame('Value cannot be blank.', $formModel->Error()->getFirst('required'));

        $formModel->load(
            [
                'RuleAttributeModel' => [
                    'hasLength' => 'sam',
                    'number' => '2',
                    'regex' => 'samdark',
                    'required' => 'samdark',
                    'url' => 'http://www.yiiframework.com',
                ],
            ],
        );
        $this->assertTrue($validator->validate($formModel)->isValid());
    }

    public function testValidateWithAttributesOptionsHasLength(): void
    {
        $formModel = new RuleAttributeModel();
        $this->assertsame(['maxlength' => 10, 'minlength' => 1], $formModel->getRuleOptionsAttribute('hasLength'));
    }

    public function testValidateWithAttributesOptionsNumber(): void
    {
        $formModel = new RuleAttributeModel();
        $this->assertsame(['max' => 10, 'min' => 1], $formModel->getRuleOptionsAttribute('number'));
    }

    public function testValidateWithAttributesOptionsRegex(): void
    {
        $formModel = new RuleAttributeModel();
        $this->assertsame(['pattern' => '^[a-zA-Z0-9]{1,10}$'], $formModel->getRuleOptionsAttribute('regex'));
    }

    public function testValidateWithAttributesOptionsRequired(): void
    {
        $formModel = new RuleAttributeModel();
        $this->assertsame(['required' => true], $formModel->getRuleOptionsAttribute('required'));
    }

    public function testValidateWithAttributesOptionsUrl(): void
    {
        $formModel = new RuleAttributeModel();
        $this->assertsame(
            ['pattern' => '^((?i)http|https):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)'],
            $formModel->getRuleOptionsAttribute('url')
        );
    }

    public function testValidateWithRules(): void
    {
        $formModel = new RuleModel();
        $validator = new Validator(new SimpleRuleHandlerContainer());

        $formModel->load(['RuleModel' => ['required' => '']]);
        $this->assertFalse($validator->validate($formModel)->isValid());
        $this->assertSame('Value cannot be blank.', $formModel->Error()->getFirst('required'));

        $formModel->load(
            [
                'RuleModel' => [
                    'hasLength' => 'sam',
                    'number' => '2',
                    'regex' => 'samdark',
                    'required' => 'samdark',
                    'url' => 'http://www.yiiframework.com',
                ],
            ],
        );
        $this->assertTrue($validator->validate($formModel)->isValid());
    }

    public function testValidateWithRulesOptionsHasLength(): void
    {
        $formModel = new RuleModel();
        $this->assertsame(['maxlength' => 10, 'minlength' => 1], $formModel->getRuleOptionsAttribute('hasLength'));
    }

    public function testValidateWithRulesOptionsHasNumber(): void
    {
        $formModel = new RuleModel();
        $this->assertsame(['max' => 10, 'min' => 1], $formModel->getRuleOptionsAttribute('number'));
    }

    public function testValidateWithRulesOptionsRegex(): void
    {
        $formModel = new RuleModel();
        $this->assertsame(['pattern' => '^[a-zA-Z0-9]{1,10}$'], $formModel->getRuleOptionsAttribute('regex'));
    }

    public function testValidateWithRulesOptionsRequired(): void
    {
        $formModel = new RuleModel();
        $this->assertsame(['required' => true], $formModel->getRuleOptionsAttribute('required'));
    }

    public function testValidateWithRulesOptionsUrl(): void
    {
        $formModel = new RuleModel();
        $this->assertsame(
            ['pattern' => '^((?i)http|https):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)'],
            $formModel->getRuleOptionsAttribute('url'),
        );
    }
}
