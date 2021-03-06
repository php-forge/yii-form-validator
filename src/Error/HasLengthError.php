<?php

declare(strict_types=1);

namespace Forge\FormValidator\Error;

use function strlen;

trait HasLengthError
{
    public function getHasLengthErrorMessge(): string
    {
        return $this->translator->withCategory('yii-form-validator')->translate('hasLength.error');
    }

    public function getHasLengthTooShortErrorMessage(int $min, string $value): string
    {
        return $this->translator
            ->withCategory('yii-form-validator')
            ->translate('hasLength.tooShortMessage.error', ['min' => $min, 'length' => strlen($value)]);
    }

    public function getHasLengthTooLongErrorMessage(int $max, string $value): string
    {
        return $this->translator
            ->withCategory('yii-form-validator')
            ->translate('hasLength.tooLongMessage.error', ['max' => $max, 'length' => strlen($value)]);
    }
}
