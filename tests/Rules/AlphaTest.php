<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\Alpha;

class AlphaTest extends TestCase
{
    public function test_onlyAlpha()
    {
        $result = (new Alpha)->passes('field', 'alpha');
        $this->assertEquals(true, $result);
    }

    public function test_capitalized()
    {
        $result = (new Alpha)->passes('field', 'Alpha');
        $this->assertEquals(true, $result);
    }

    public function test_withNumber()
    {
        $result = (new Alpha)->passes('field', 'alpha1234');
        $this->assertEquals(false, $result);
    }

    public function test_withDash()
    {
        $result = (new Alpha)->passes('field', 'alpha+beta');
        $this->assertEquals(false, $result);
    }

    public function test_withHiragana()
    {
        $result = (new Alpha)->passes('field', 'alphaひらがな');
        $this->assertEquals(false, $result);
    }

    public function test_withSpace()
    {
        $result = (new Alpha)->passes('field', 'al pha');
        $this->assertEquals(false, $result);
    }

    public function test_withSpaceAllowed()
    {
        $result = (new Alpha(['withSpace' => true]))->passes('field', 'al pha');
        $this->assertEquals(true, $result);
    }
}
