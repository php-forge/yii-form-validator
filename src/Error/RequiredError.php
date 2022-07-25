<?php

declare(strict_types=1);

namespace Forge\FormValidator\Error;

trait RequiredError
{
    public function getRequiredErrorMessage(): string
    {
        return $this->translator->withCategory('yii-form-validator')->translate('required.error');
    }
}
