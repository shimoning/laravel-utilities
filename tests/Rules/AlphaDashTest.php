<?php

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

    public function test_withNumber()
    {
        $result = (new AlphaDash)->passes('field', 'alpha1234');
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

    public function test_withHiragana()
    {
        $result = (new AlphaDash)->passes('field', 'alphaひらがな');
        $this->assertEquals(false, $result);
    }
}
