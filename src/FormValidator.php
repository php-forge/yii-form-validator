<?php

declare(strict_types=1);

namespace Forge\FormValidator;

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
        /** @psalm-var array<array-key, Rule> */
        $formModelRules = $this->getRules();
        $rules = [];

        if (array_key_exists($attribute, $formModelRules)) {
            $rules = $formModelRules[$attribute];
        }

        /** @psalm-var array<array-key, Rule>  $rules */
        foreach ($rules as $rule) {
            if ($rule instanceof HasLength) {
                /** @var int|null */
                $attributes['maxlength'] = $rule->getOptions()['max'] !== null ? $rule->getOptions()['max'] : null;
                /** @var int|null */
                $attributes['minlength'] = $rule->getOptions()['min'] !== null ? $rule->getOptions()['min'] : null;
            }

            if ($rule instanceof Number) {
                /** @var int|null */
                $attributes['max'] = $rule->getOptions()['max'] !== null ? $rule->getOptions()['max'] : null;
                /** @var int|null */
                $attributes['min'] = $rule->getOptions()['min'] !== null ? $rule->getOptions()['min'] : null;
            }

            if ($rule instanceof Regex) {
                /** @var string */
                $pattern = $rule->getOptions()['pattern'];
                $attributes['pattern'] = Utils::normalizeRegexpPattern($pattern);
            }

            if ($rule instanceof Required) {
                $attributes['required'] = true;
            }

            if ($rule instanceof Url) {
                /** @var array<array-key, string> */
                $validSchemes = $rule->getOptions()['validSchemes'];

                $schemes = [];

                foreach ($validSchemes as $scheme) {
                    $schemes[] = $this->getSchemePattern($scheme);
                }

                /** @var array<array-key, float|int|string>|string */
                $pattern = $rule->getOptions()['pattern'];
                $normalizePattern = str_replace('{schemes}', '(' . implode('|', $schemes) . ')', $pattern);
                $attributes['pattern'] = Utils::normalizeRegexpPattern($normalizePattern);
            }
        }

        return $attributes;
    }

    protected function getRulesByAttributes(): iterable
    {
        $attributeDataSet = new AttributeDataSet($this, $this->getData());

        return $attributeDataSet->getRules();
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

    private function getSchemePattern(string $scheme): string
    {
        $result = '';

        for ($i = 0, $length = strlen($scheme); $i < $length; $i++) {
            $result .= '[' . strtolower($scheme[$i]) . strtoupper($scheme[$i]) . ']';
        }

        return $result;
    }
}
