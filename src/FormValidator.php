<?php

declare(strict_types=1);

namespace Forge\FormValidator;

use Forge\Model\FormModel;
use Yiisoft\Validator\DataSet\AttributeDataSet;
use Yiisoft\Validator\PostValidationHookInterface;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RulesProviderInterface;

abstract class FormValidator extends FormModel implements PostValidationHookInterface, RulesProviderInterface
{
    public function getRules(): array
    {
        $attributeDataSet = new AttributeDataSet($this, $this->getData());

        return $attributeDataSet->getRules();
    }

    public function processValidationResult(Result $result): void
    {
        foreach ($result->getErrorMessagesIndexedByAttribute() as $attribute => $errors) {
            if ($this->has($attribute)) {
                $this->addErrors([$attribute => $errors]);
            }
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
