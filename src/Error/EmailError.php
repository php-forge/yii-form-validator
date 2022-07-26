<?php

declare(strict_types=1);

namespace Forge\FormValidator\Error;

trait EmailError
{
    public function getEmailErrorMessage(): string
    {
        return $this->translator->withCategory('yii-form-validator')->translate('email.error');
    }
}
