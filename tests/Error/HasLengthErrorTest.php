<?php

declare(strict_types=1);

namespace Forge\FormValidator\Test\Error;

use Forge\FormValidator\Tests\Support\TranslatorModel;
use PHPUnit\Framework\TestCase;

final class HasLengthErrorTest extends TestCase
{
    public function testGetRulesMessage(): void
    {
        $formModel = new TranslatorModel();

        $this->assertSame('This value must be a string.', $formModel->getHasLengthErrorMessge());
        $this->assertSame(
            'This value should contain at least 1 characters or more, currently has 7 characters.',
            $formModel->getHasLengthTooShortErrorMessage(1, 'samdark'),
        );
        $this->assertSame(
            'This value should contain at most 10 characters or less, currently has 7 characters.',
            $formModel->getHasLengthTooLongErrorMessage(10, 'samdark'),
        );
    }
}
