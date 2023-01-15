<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\PhoneNumber;

class PhoneNumberTest extends TestCase
{
    public function test_withHyphen()
    {
        $result = (new PhoneNumber)->passes('field', '012-3456-7890');
        $this->assertEquals(true, $result);
    }

    public function test_withoutHyphen()
    {
        $result = (new PhoneNumber)->passes('field', '01234567890');
        $this->assertEquals(true, $result);
    }

    public function test_withCountryCode()
    {
        $result = (new PhoneNumber)->passes('field', '+811234567890');
        $this->assertEquals(false, $result);
    }

    public function test_failed()
    {
        $result = (new PhoneNumber)->passes('field', '012345-67-890');
        $this->assertEquals(false, $result);
    }

    public function test_failed2()
    {
        $result = (new PhoneNumber)->passes('field', '012-34567-890');
        $this->assertEquals(false, $result);
    }

    public function test_failed3()
    {
        $result = (new PhoneNumber)->passes('field', '012-34567-89');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyHyphenRequired()
    {
        $result = (new PhoneNumber(['hyphenRequired' => true]))->passes('field', '012-3456-7890');
        $this->assertEquals(true, $result);
    }

    public function test_failedHyphenRequired()
    {
        $result = (new PhoneNumber(['hyphenRequired' => true]))->passes('field', '01234567890');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyHyphenIgnored()
    {
        $result = (new PhoneNumber(['hyphenIgnored' => true]))->passes('field', '01234567890');
        $this->assertEquals(true, $result);
    }

    public function test_failedHyphenIgnored()
    {
        $result = (new PhoneNumber(['hyphenIgnored' => true]))->passes('field', '012-3456-7890');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithCountryCode()
    {
        $result = (new PhoneNumber(['withCountryCode' => true]))->passes('field', '+811234567890');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithCountryCode()
    {
        $result = (new PhoneNumber(['withCountryCode' => true]))->passes('field', '012-3456-7890');
        $this->assertEquals(false, $result);
    }

    public function test_lastLf()
    {
        $result = (new PhoneNumber)->passes('field', "01234567890\n");
        $this->assertEquals(false, $result);
    }

    public function test_last2Lf()
    {
        $result = (new PhoneNumber)->passes('field', "01234567890\n\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastCrLf()
    {
        $result = (new PhoneNumber)->passes('field', "01234567890\r\n");
        $this->assertEquals(false, $result);
    }

    public function test_includingLf()
    {
        $result = (new PhoneNumber)->passes('field', "01234\n567890");
        $this->assertEquals(false, $result);
    }
}
