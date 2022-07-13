<?php

declare(strict_types=1);

namespace Forge\FormValidator\Tests\Support;

use Forge\FormValidator\FormValidator;
use Yiisoft\Validator\Rule\Required;

final class RuleModel extends FormValidator
{
    private string $email = '';

    public function getRules(): array
    {
        return [
            'email' => [new Required()],
        ];
    }
}
