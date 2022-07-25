<?php

declare(strict_types=1);

namespace Forge\FormValidator\Error;

trait UrlError
{
    public function getUrlErrorMessage(): string
    {
        return $this->translator->withCategory('yii-form-validator')->translate('url.error');
    }
}
