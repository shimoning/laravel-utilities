<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\CapitalizedAlpha;

class CapitalizedAlphaTest extends TestCase
{
    public function test_onlyCapitalized()
    {
        $result = (new CapitalizedAlpha)->passes('field', 'ALPHA');
        $this->assertEquals(true, $result);
    }

    public function test_onlyLowercase()
    {
        $result = (new CapitalizedAlpha)->passes('field', 'alpha');
        $this->assertEquals(false, $result);
    }

    public function test_withLowercase()
    {
        $result = (new CapitalizedAlpha)->passes('field', 'Alpha');
        $this->assertEquals(false, $result);
    }

    public function test_withNumber()
    {
        $result = (new CapitalizedAlpha)->passes('field', 'alpha1234');
        $this->assertEquals(false, $result);
    }

    public function test_withUnderscore()
    {
        $result = (new CapitalizedAlpha)->passes('field', 'alpha_beta');
        $this->assertEquals(false, $result);
    }

    public function test_withDash()
    {
        $result = (new CapitalizedAlpha)->passes('field', 'alpha-beta');
        $this->assertEquals(false, $result);
    }

    public function test_withHiragana()
    {
        $result = (new CapitalizedAlpha)->passes('field', 'alphaひらがな');
        $this->assertEquals(false, $result);
    }

    public function test_lastLf()
    {
        $result = (new CapitalizedAlpha)->passes('field', "ALPHA\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastLfAllowedMultiline()
    {
        $result = (new CapitalizedAlpha(['allowMultiline' => true]))->passes('field', "ALPHA\n");
        $this->assertEquals(true, $result);
    }

    public function test_last2Lf()
    {
        $result = (new CapitalizedAlpha)->passes('field', "ALPHA\n\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastCrLf()
    {
        $result = (new CapitalizedAlpha)->passes('field', "ALPHA\r\n");
        $this->assertEquals(false, $result);
    }

    public function test_includingLf()
    {
        $result = (new CapitalizedAlpha)->passes('field', "AL\nPHA");
        $this->assertEquals(false, $result);
    }
}
