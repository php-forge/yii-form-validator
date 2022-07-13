<?php

declare(strict_types=1);

namespace Forge\FormValidator\Tests\Support;

use Forge\FormValidator\FormValidator;
use Yiisoft\Validator\Rule\Required;

final class RuleAttributeModel extends FormValidator
{
    #[Required]
    private string $email = '';
}
