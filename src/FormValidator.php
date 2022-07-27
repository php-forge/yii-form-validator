<?php

declare(strict_types=1);

namespace Forge\FormValidator;

use Forge\Html\Helper\Attribute;
use Forge\Html\Helper\Utils;
use Forge\Model\FormModel;
use Yiisoft\Validator\DataSet\AttributeDataSet;
use Yiisoft\Validator\PostValidationHookInterface;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\RulesProviderInterface;

abstract class FormValidator extends FormModel implements PostValidationHookInterface, RulesProviderInterface
{
    public function getRules(): array
    {
        return [];
    }

    public function processValidationResult(Result $result): void
    {
        foreach ($result->getErrorMessagesIndexedByAttribute() as $attribute => $errors) {
            if ($this->has($attribute)) {
                $this->addErrors([$attribute => $errors]);
            }
        }
    }

    public function getRuleOptionsAttribute(string $attribute): array
    {
        $attributes = [];
        /** @psalm-var array<array-key, RuleInterface> */
        $formModelRules = $this->getRules();
        $rules = [];

        if (array_key_exists($attribute, $formModelRules)) {
            $rules = $formModelRules[$attribute];
        }

        /** @psalm-var array<array-key, RuleInterface>  $rules */
        foreach ($rules as $rule) {
            if ($rule instanceof RuleInterface) {
                $this->checkRuleHasLength($rule, $attributes);
                $this->checkRuleNumber($rule, $attributes);
                $this->checkRuleRegex($rule, $attributes);
                $this->checkRuleRequired($rule, $attributes);
                $this->checkRuleUrl($rule, $attributes);
            }
        }

        return $attributes;
    }

    protected function getRulesByAttributes(): iterable
    {
        $attributeDataSet = new AttributeDataSet($this, $this->getData());

        return $attributeDataSet->getRules();
    }

    private function checkRuleHasLength(RuleInterface $rule, array &$attributes): void
    {
        if ($rule instanceof HasLength) {
            Attribute::add(
                $attributes,
                'maxlength',
                $rule->getOptions()['max'] !== null ? $rule->getOptions()['max'] : null,
            );
            Attribute::add(
                $attributes,
                'minlength',
                $rule->getOptions()['min'] !== null ? $rule->getOptions()['min'] : null,
            );
        }
    }

    private function checkRuleNumber(RuleInterface $rule, array &$attributes): void
    {
        if ($rule instanceof Number) {
            Attribute::add(
                $attributes,
                'max',
                $rule->getOptions()['max'] !== null ? $rule->getOptions()['max'] : null,
            );
            Attribute::add(
                $attributes,
                'min',
                $rule->getOptions()['min'] !== null ? $rule->getOptions()['min'] : null,
            );
        }
    }

    private function checkRuleRegex(RuleInterface $rule, array &$attributes): void
    {
        if ($rule instanceof Regex) {
            /** @var string */
            $pattern = $rule->getOptions()['pattern'];
            Attribute::add(
                $attributes,
                'pattern',
                Utils::normalizeRegexpPattern($pattern),
            );
        }
    }

    private function checkRuleRequired(RuleInterface $rule, array &$attributes): void
    {
        if ($rule instanceof Required) {
            Attribute::add($attributes, 'required', true);
        }
    }

    private function checkRuleUrl(RuleInterface $rule, array &$attributes): void
    {
        if ($rule instanceof Url) {
            /** @var array<array-key, float|int|string>|string */
            $pattern = $rule->getOptions()['pattern'];
            $attributes['pattern'] = Utils::normalizeRegexpPattern($pattern);
        }
    }

    /**
     * @psalm-param non-empty-array<string, non-empty-list<string>> $items
     */
    private function addErrors(array $items): void
    {
        foreach ($items as $attribute => $errors) {
            foreach ($errors as $error) {
                $this->error()->add($attribute, $error);
            }
        }
    }
}
