<?php

declare(strict_types=1);

namespace Forge\FormValidator\Tests\Support;

use Forge\FormValidator\Error;
use Forge\FormValidator\FormValidator;
use Yiisoft\Translator\CategorySource;
use Yiisoft\Translator\Formatter\Simple\SimpleMessageFormatter;
use Yiisoft\Translator\Message\Php\MessageSource;
use Yiisoft\Translator\Translator;

final class TranslatorModel extends FormValidator
{
    use Error\EmailError;
    use Error\HasLengthError;
    use Error\InRangeError;
    use Error\RequiredError;
    use Error\UrlError;

    private Translator $translator;

    public function __construct()
    {
        $this->translator = new Translator('en', null);
        $this->translator->addCategorySource($this->createCategory('yii-form-validator'));
    }

    private function createCategory(string $categoryName): CategorySource
    {
        $messageSource = new MessageSource(dirname(__DIR__, 2) . '/storage/message');

        return new CategorySource('yii-form-validator', $messageSource, new SimpleMessageFormatter());
    }
}
