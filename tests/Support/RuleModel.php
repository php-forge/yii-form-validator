<?php

declare(strict_types=1);

namespace Forge\FormValidator\Tests\Support;

use Forge\FormValidator\FormValidator;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url;

final class RuleModel extends FormValidator
{
    private string $hasLength = '';
    private string $number = '';
    private string $regex = '';
    private string $required = '';
    private string $url = '';

    public function getRules(): array
    {
        return [
            'hasLength' => [new HasLength(min: 1, max: 10)],
            'number' => [new Number(min: 1, max: 10)],
            'regex' => [new Regex('/^[a-zA-Z0-9]{1,10}$/')],
            'required' => [new Required()],
            'url' => [new Url()],
        ];
    }
}
