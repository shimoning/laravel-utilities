<?php

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\Time;

class TimeTest extends TestCase
{
    public function test_successfullyFirst0()
    {
        $result = (new Time)->passes('field', '01:23:45');
        $this->assertEquals(true, $result);
    }

    public function test_failedFirst0_1()
    {
        $result = (new Time)->passes('field', '01:60:45');
        $this->assertEquals(false, $result);
    }

    public function test_failedFirst0_2()
    {
        $result = (new Time)->passes('field', '01:23:61');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyFirst1()
    {
        $result = (new Time)->passes('field', '12:34:56');
        $this->assertEquals(true, $result);
    }

    public function test_failedFirst1_1()
    {
        $result = (new Time)->passes('field', '12:61:56');
        $this->assertEquals(false, $result);
    }

    public function test_failedFirst1_2()
    {
        $result = (new Time)->passes('field', '12:34:78');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyFirst2()
    {
        $result = (new Time)->passes('field', '23:23:45');
        $this->assertEquals(true, $result);
    }

    public function test_failedFirst2_1()
    {
        $result = (new Time)->passes('field', '25:23:45');
        $this->assertEquals(false, $result);
    }

    public function test_failedFirst2_2()
    {
        $result = (new Time)->passes('field', '23:61:45');
        $this->assertEquals(false, $result);
    }

    public function test_failedFirst2_3()
    {
        $result = (new Time)->passes('field', '23:23:90');
        $this->assertEquals(false, $result);
    }

    public function test_allowOver24()
    {
        $result = (new Time(['allowOver24' => true]))->passes('field', '25:23:45');
        $this->assertEquals(true, $result);
    }

    public function test_allowOver24_2()
    {
        $result = (new Time(['allowOver24' => true]))->passes('field', '1:23:45');
        $this->assertEquals(true, $result);
    }

    public function test_successfullyWithoutSecond()
    {
        $result = (new Time(['allowOver24' => true]))->passes('field', '01:23');
        $this->assertEquals(true, $result);
    }

    public function test_successfullySecondRequired()
    {
        $result = (new Time(['secondRequired' => true]))->passes('field', '01:23:45');
        $this->assertEquals(true, $result);
    }

    public function test_failedSecondRequired()
    {
        $result = (new Time(['secondRequired' => true]))->passes('field', '01:23');
        $this->assertEquals(false, $result);
    }

    public function test_successfullySecondIgnored()
    {
        $result = (new Time(['secondIgnored' => true]))->passes('field', '01:23');
        $this->assertEquals(true, $result);
    }

    public function test_failedSecondIgnored()
    {
        $result = (new Time(['secondIgnored' => true]))->passes('field', '01:23:45');
        $this->assertEquals(false, $result);
    }
}
