<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\AlphaNumDash;

class AlphaNumDashTest extends TestCase
{
    public function test_onlyAlpha()
    {
        $result = (new AlphaNumDash)->passes('field', 'alpha');
        $this->assertEquals(true, $result);
    }

    public function test_capitalized()
    {
        $result = (new AlphaNumDash)->passes('field', 'Alpha');
        $this->assertEquals(true, $result);
    }

    public function test_withNumber()
    {
        $result = (new AlphaNumDash)->passes('field', 'alpha1234');
        $this->assertEquals(true, $result);
    }

    public function test_withUnderscore()
    {
        $result = (new AlphaNumDash)->passes('field', 'alpha_beta');
        $this->assertEquals(true, $result);
    }

    public function test_withDash()
    {
        $result = (new AlphaNumDash)->passes('field', 'alpha-beta');
        $this->assertEquals(true, $result);
    }

    public function test_withHiragana()
    {
        $result = (new AlphaNumDash)->passes('field', 'alphaひらがな');
        $this->assertEquals(false, $result);
    }

    public function test_withSpace()
    {
        $result = (new AlphaNumDash)->passes('field', 'al pha-1234');
        $this->assertEquals(false, $result);
    }

    public function test_withSpaceAllowed()
    {
        $result = (new AlphaNumDash(['withSpace' => true]))->passes('field', 'al pha_1234');
        $this->assertEquals(true, $result);
    }
}
