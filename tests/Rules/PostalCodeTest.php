<?php

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\PostalCode;

class PostalCodeTest extends TestCase
{
    public function test_withHyphen()
    {
        $result = (new PostalCode)->passes('field', '012-3456');
        $this->assertEquals(true, $result);
    }

    public function test_withoutHyphen()
    {
        $result = (new PostalCode)->passes('field', '0123456');
        $this->assertEquals(true, $result);
    }

    public function test_failed()
    {
        $result = (new PostalCode)->passes('field', '012');
        $this->assertEquals(false, $result);
    }

    public function test_failed2()
    {
        $result = (new PostalCode)->passes('field', '01234');
        $this->assertEquals(false, $result);
    }

    public function test_failed3()
    {
        $result = (new PostalCode)->passes('field', '012-345');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyHyphenRequired()
    {
        $result = (new PostalCode(['hyphenRequired' => true]))->passes('field', '012-3456');
        $this->assertEquals(true, $result);
    }

    public function test_failedHyphenRequired()
    {
        $result = (new PostalCode(['hyphenRequired' => true]))->passes('field', '0123456');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyHyphenIgnored()
    {
        $result = (new PostalCode(['hyphenIgnored' => true]))->passes('field', '0123456');
        $this->assertEquals(true, $result);
    }

    public function test_failedHyphenIgnored()
    {
        $result = (new PostalCode(['hyphenIgnored' => true]))->passes('field', '012-3456');
        $this->assertEquals(false, $result);
    }
}
