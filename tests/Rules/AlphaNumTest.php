<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\AlphaNum;

class AlphaNumTest extends TestCase
{
    public function test_onlyAlpha()
    {
        $result = (new AlphaNum)->passes('field', 'alpha');
        $this->assertEquals(true, $result);
    }

    public function test_capitalized()
    {
        $result = (new AlphaNum)->passes('field', 'Alpha');
        $this->assertEquals(true, $result);
    }

    public function test_withNumber()
    {
        $result = (new AlphaNum)->passes('field', 'alpha1234');
        $this->assertEquals(true, $result);
    }

    public function test_withUnderscore()
    {
        $result = (new AlphaNum)->passes('field', 'alpha_beta');
        $this->assertEquals(false, $result);
    }

    public function test_withDash()
    {
        $result = (new AlphaNum)->passes('field', 'alpha-beta');
        $this->assertEquals(false, $result);
    }

    public function test_withHiragana()
    {
        $result = (new AlphaNum)->passes('field', 'alphaひらがな');
        $this->assertEquals(false, $result);
    }
}
