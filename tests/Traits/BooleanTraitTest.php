<?php

namespace Shimoning\Tests\Traits;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Traits\BooleanTrait;

class Boolean { use BooleanTrait; }

class BooleanTraitTest extends TestCase
{
    public function test_null()
    {
        $result = (new Boolean)->toBoolean(null);
        $this->assertFalse($result);
    }

    public function test_emptyString()
    {
        $result = (new Boolean)->toBoolean('');
        $this->assertFalse($result);
    }

    public function test_space()
    {
        $result = (new Boolean)->toBoolean(' ');
        $this->assertFalse($result);
    }

    public function test_multiByteSpace()
    {
        $result = (new Boolean)->toBoolean('　');
        $this->assertNull($result);
    }

    public function test_booleanTrue()
    {
        $result = (new Boolean)->toBoolean(true);
        $this->assertTrue($result);
    }

    public function test_booleanFalse()
    {
        $result = (new Boolean)->toBoolean(false);
        $this->assertFalse($result);
    }

    public function test_stringTrue()
    {
        $result = (new Boolean)->toBoolean('true');
        $this->assertTrue($result);
    }

    public function test_stringFalse()
    {
        $result = (new Boolean)->toBoolean('false');
        $this->assertFalse($result);
    }

    public function test_number1()
    {
        $result = (new Boolean)->toBoolean(1);
        $this->assertTrue($result);
    }

    public function test_number0()
    {
        $result = (new Boolean)->toBoolean(0);
        $this->assertFalse($result);
    }

    public function test_string1()
    {
        $result = (new Boolean)->toBoolean('1');
        $this->assertTrue($result);
    }

    public function test_string0()
    {
        $result = (new Boolean)->toBoolean('0');
        $this->assertFalse($result);
    }

    public function test_on()
    {
        $result = (new Boolean)->toBoolean('on');
        $this->assertTrue($result);
    }

    public function test_off()
    {
        $result = (new Boolean)->toBoolean('off');
        $this->assertFalse($result);
    }

    public function test_yes()
    {
        $result = (new Boolean)->toBoolean('yes');
        $this->assertTrue($result);
    }

    public function test_no()
    {
        $result = (new Boolean)->toBoolean('no');
        $this->assertFalse($result);
    }

    public function test_number10()
    {
        $result = (new Boolean)->toBoolean(10);
        $this->assertNull($result);
    }

    public function test_string10()
    {
        $result = (new Boolean)->toBoolean('10');
        $this->assertNull($result);
    }

    public function test_alphabet()
    {
        $result = (new Boolean)->toBoolean('a');
        $this->assertNull($result);
    }

    public function test_array()
    {
        $result = (new Boolean)->toBoolean([]);
        $this->assertNull($result);
    }
}
