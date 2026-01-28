<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\Zenkaku;

class ZenkakuTest extends TestCase
{
    public function test_onlyKanji()
    {
        $result = (new Zenkaku)->passes('field', '漢字');
        $this->assertEquals(true, $result);
    }

    public function test_onlyHiragana()
    {
        $result = (new Zenkaku)->passes('field', 'ひらがな');
        $this->assertEquals(true, $result);
    }

    public function test_withSmall()
    {
        $result = (new Zenkaku)->passes('field', 'ひらがなぁ');
        $this->assertEquals(true, $result);
    }

    public function test_withChohon()
    {
        $result = (new Zenkaku)->passes('field', 'ひらがーな');
        $this->assertEquals(true, $result);
    }

    public function test_withKatakana()
    {
        $result = (new Zenkaku)->passes('field', 'ひらガナ');
        $this->assertEquals(true, $result);
    }

    public function test_successfullyWithSpace()
    {
        $result = (new Zenkaku(['withHalfSpace' => true]))->passes('field', 'ひら がな');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithSpace()
    {
        $result = (new Zenkaku)->passes('field', 'ひら がな');
        $this->assertEquals(false, $result);
    }

    public function test_withMultibyteSpace()
    {
        $result = (new Zenkaku)->passes('field', 'ひら　がな');
        $this->assertEquals(true, $result);
    }

    public function test_withAlpha()
    {
        $result = (new Zenkaku)->passes('field', 'ひらgana');
        $this->assertEquals(false, $result);
    }

    public function test_withNumber()
    {
        $result = (new Zenkaku)->passes('field', 'ひら1234');
        $this->assertEquals(false, $result);
    }

    public function test_withKanji()
    {
        $result = (new Zenkaku)->passes('field', 'ひら仮名');
        $this->assertEquals(true, $result);
    }

    public function test_lastLf()
    {
        $result = (new Zenkaku)->passes('field', "ひらがな\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastLfAllowedMultiline()
    {
        $result = (new Zenkaku(['allowMultiline' => true]))->passes('field', "ひらがな\n");
        $this->assertEquals(true, $result);
    }

    public function test_last2Lf()
    {
        $result = (new Zenkaku)->passes('field', "ひらがな\n\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastCrLf()
    {
        $result = (new Zenkaku)->passes('field', "ひらがな\r\n");
        $this->assertEquals(false, $result);
    }

    public function test_includingLf()
    {
        $result = (new Zenkaku)->passes('field', "ひら\nがな");
        $this->assertEquals(false, $result);
    }
}
