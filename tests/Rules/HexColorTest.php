<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\HexColor;

class HexColorTest extends TestCase
{
    public function test_successfullyLong()
    {
        $result = (new HexColor)->passes('field', '#ffffff');
        $this->assertEquals(true, $result);
    }

    public function test_failedLong()
    {
        $result = (new HexColor)->passes('field', '#gggggg');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyShort()
    {
        $result = (new HexColor)->passes('field', '#fff');
        $this->assertEquals(true, $result);
    }

    public function test_failedShort()
    {
        $result = (new HexColor)->passes('field', '#ggg');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithoutHash()
    {
        $result = (new HexColor(['withHash' => false]))->passes('field', 'ffffff');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithoutHash()
    {
        $result = (new HexColor(['withHash' => false]))->passes('field', '#ffffff');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyDisallowedLong()
    {
        $result = (new HexColor(['allowLong' => false]))->passes('field', '#fff');
        $this->assertEquals(true, $result);
    }

    public function test_failedDisallowedLong()
    {
        $result = (new HexColor(['allowLong' => false]))->passes('field', '#ffffff');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyDisallowedShort()
    {
        $result = (new HexColor(['allowShort' => false]))->passes('field', '#ffffff');
        $this->assertEquals(true, $result);
    }

    public function test_failedDisallowedShort()
    {
        $result = (new HexColor(['allowShort' => false]))->passes('field', '#fff');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithoutHashAndDisallowedLong()
    {
        $result = (new HexColor(['withHash' => false, 'allowLong' => false]))->passes('field', 'fff');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithoutHashAndDisallowedLong()
    {
        $result = (new HexColor(['withHash' => false, 'allowLong' => false]))->passes('field', '#ffffff');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithoutHashAndDisallowedShort()
    {
        $result = (new HexColor(['withHash' => false, 'allowShort' => false]))->passes('field', 'ffffff');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithoutHashAndDisallowedShort()
    {
        $result = (new HexColor(['withHash' => false, 'allowShort' => false]))->passes('field', '#fff');
        $this->assertEquals(false, $result);
    }

    public function test_disallowedLongAndDisallowedShort()
    {
        // always falsy
        $result = (new HexColor(['allowLong' => false, 'allowShort' => false]))->passes('field', '#ffffff');
        $this->assertEquals(false, $result);
    }

    public function test_lastLf()
    {
        $result = (new HexColor)->passes('field', "#ffffff\n");
        $this->assertEquals(false, $result);
    }

    public function test_last2Lf()
    {
        $result = (new HexColor)->passes('field', "#ffffff\n\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastCrLf()
    {
        $result = (new HexColor)->passes('field', "#ffffff\r\n");
        $this->assertEquals(false, $result);
    }

    public function test_includingLf()
    {
        $result = (new HexColor)->passes('field', "#ff\nffff");
        $this->assertEquals(false, $result);
    }
}
