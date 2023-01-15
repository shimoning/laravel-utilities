<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\AlphaDash;

class AlphaDashTest extends TestCase
{
    public function test_onlyAlpha()
    {
        $result = (new AlphaDash)->passes('field', 'alpha');
        $this->assertEquals(true, $result);
    }

    public function test_capitalized()
    {
        $result = (new AlphaDash)->passes('field', 'Alpha');
        $this->assertEquals(true, $result);
    }

    public function test_withUnderscore()
    {
        $result = (new AlphaDash)->passes('field', 'alpha_beta');
        $this->assertEquals(true, $result);
    }

    public function test_withDash()
    {
        $result = (new AlphaDash)->passes('field', 'alpha-beta');
        $this->assertEquals(true, $result);
    }

    public function test_startNumber()
    {
        $result = (new AlphaDash)->passes('field', '1234alpha');
        $this->assertEquals(false, $result);
    }

    public function test_lastNumber()
    {
        $result = (new AlphaDash)->passes('field', 'alpha1234');
        $this->assertEquals(false, $result);
    }

    public function test_withHiragana()
    {
        $result = (new AlphaDash)->passes('field', 'alphaひらがな');
        $this->assertEquals(false, $result);
    }

    public function test_withSpace()
    {
        $result = (new AlphaDash)->passes('field', 'al p-ha');
        $this->assertEquals(false, $result);
    }

    public function test_withSpaceAllowed()
    {
        $result = (new AlphaDash(['withSpace' => true]))->passes('field', 'al p_ha');
        $this->assertEquals(true, $result);
    }

    public function test_lastLf()
    {
        $result = (new AlphaDash)->passes('field', "alpha\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastLfAllowedMultiline()
    {
        $result = (new AlphaDash(['allowMultiline' => true]))->passes('field', "alpha\n");
        $this->assertEquals(true, $result);
    }

    public function test_last2Lf()
    {
        $result = (new AlphaDash)->passes('field', "alpha\n\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastCrLf()
    {
        $result = (new AlphaDash)->passes('field', "alpha\r\n");
        $this->assertEquals(false, $result);
    }

    public function test_includingLf()
    {
        $result = (new AlphaDash)->passes('field', "al\npha");
        $this->assertEquals(false, $result);
    }
}
