<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\Boolean;

class BooleanTest extends TestCase
{
    public function test_null()
    {
        $result = (new Boolean)->passes('field', null);
        $this->assertEquals(true, $result);
    }

    public function test_emptyString()
    {
        $result = (new Boolean)->passes('field', '');
        $this->assertEquals(true, $result);
    }

    public function test_space()
    {
        $result = (new Boolean)->passes('field', ' ');
        $this->assertEquals(true, $result);
    }

    public function test_multiByteSpace()
    {
        $result = (new Boolean)->passes('field', '　');
        $this->assertEquals(false, $result);
    }

    public function test_booleanTrue()
    {
        $result = (new Boolean)->passes('field', true);
        $this->assertEquals(true, $result);
    }

    public function test_booleanFalse()
    {
        $result = (new Boolean)->passes('field', false);
        $this->assertEquals(true, $result);
    }

    public function test_stringTrue()
    {
        $result = (new Boolean)->passes('field', 'true');
        $this->assertEquals(true, $result);
    }

    public function test_stringFalse()
    {
        $result = (new Boolean)->passes('field', 'false');
        $this->assertEquals(true, $result);
    }

    public function test_number1()
    {
        $result = (new Boolean)->passes('field', 1);
        $this->assertEquals(true, $result);
    }

    public function test_number0()
    {
        $result = (new Boolean)->passes('field', 0);
        $this->assertEquals(true, $result);
    }

    public function test_string1()
    {
        $result = (new Boolean)->passes('field', '1');
        $this->assertEquals(true, $result);
    }

    public function test_string0()
    {
        $result = (new Boolean)->passes('field', '0');
        $this->assertEquals(true, $result);
    }

    public function test_on()
    {
        $result = (new Boolean)->passes('field', 'on');
        $this->assertEquals(true, $result);
    }

    public function test_off()
    {
        $result = (new Boolean)->passes('field', 'off');
        $this->assertEquals(true, $result);
    }

    public function test_yes()
    {
        $result = (new Boolean)->passes('field', 'yes');
        $this->assertEquals(true, $result);
    }

    public function test_no()
    {
        $result = (new Boolean)->passes('field', 'no');
        $this->assertEquals(true, $result);
    }

    public function test_number10()
    {
        $result = (new Boolean)->passes('field', 10);
        $this->assertEquals(false, $result);
    }

    public function test_string10()
    {
        $result = (new Boolean)->passes('field', '10');
        $this->assertEquals(false, $result);
    }

    public function test_alphabet()
    {
        $result = (new Boolean)->passes('field', 'a');
        $this->assertEquals(false, $result);
    }

    public function test_array()
    {
        $result = (new Boolean)->passes('field', []);
        $this->assertEquals(false, $result);
    }
}
