<?php

declare(strict_types=1);

namespace Forge\FormValidator\Error;

trait InRangeError
{
    public function getInRangeErrorMessage(): string
    {
        return $this->translator->withCategory('yii-form-validator')->translate('inRange.error');
    }
}
