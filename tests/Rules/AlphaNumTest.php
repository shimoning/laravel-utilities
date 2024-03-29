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
        $result = (new AlphaNum)->passes('field', 'alpha_beta1234');
        $this->assertEquals(false, $result);
    }

    public function test_withDash()
    {
        $result = (new AlphaNum)->passes('field', 'alpha-beta1234');
        $this->assertEquals(false, $result);
    }

    public function test_withHiragana()
    {
        $result = (new AlphaNum)->passes('field', 'alphaひらがな1234');
        $this->assertEquals(false, $result);
    }

    public function test_withSpace()
    {
        $result = (new AlphaNum)->passes('field', 'al pha1234');
        $this->assertEquals(false, $result);
    }

    public function test_withSpaceAllowed()
    {
        $result = (new AlphaNum(['withSpace' => true]))->passes('field', 'al pha1234');
        $this->assertEquals(true, $result);
    }

    public function test_lastLf()
    {
        $result = (new AlphaNum)->passes('field', "alpha\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastLfAllowedMultiline()
    {
        $result = (new AlphaNum(['allowMultiline' => true]))->passes('field', "alpha\n");
        $this->assertEquals(true, $result);
    }

    public function test_last2Lf()
    {
        $result = (new AlphaNum)->passes('field', "alpha\n\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastCrLf()
    {
        $result = (new AlphaNum)->passes('field', "alpha\r\n");
        $this->assertEquals(false, $result);
    }

    public function test_includingLf()
    {
        $result = (new AlphaNum)->passes('field', "al\npha");
        $this->assertEquals(false, $result);
    }
}
