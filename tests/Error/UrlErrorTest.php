<?php

declare(strict_types=1);

namespace Forge\FormValidator\Test\Error;

use Forge\FormValidator\Tests\Support\TranslatorModel;
use PHPUnit\Framework\TestCase;

final class UrlErrorTest extends TestCase
{
    public function testGetRulesMessage(): void
    {
        $formModel = new TranslatorModel();

        $this->assertSame('This value is not a valid URL.', $formModel->getUrlErrorMessage());
    }
}
