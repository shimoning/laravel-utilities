<?php

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\Boolean;

class BooleanTest extends TestCase
{
    public function test_null()
    {
        $result = (new Boolean)->passes('field', null);
        $this->assertEquals(true, $result);
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
}
