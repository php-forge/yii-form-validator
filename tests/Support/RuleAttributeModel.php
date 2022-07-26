<?php

declare(strict_types=1);

namespace Forge\FormValidator\Tests\Support;

use Forge\FormValidator\FormValidator;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url;

final class RuleAttributeModel extends FormValidator
{
    #[HasLength(min: 1, max: 10)]
    private string $hasLength = '';
    #[Number(min: 1, max: 10)]
    private string $number = '';
    #[Regex('/^[a-zA-Z0-9]{1,10}$/')]
    private string $regex = '';
    #[Required]
    private string $required = '';
    #[Url]
    private string $url = '';

    public function getRules(): array
    {
        return $this->getRulesByAttributes();
    }
}
