<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\Hiragana;

class HiraganaTest extends TestCase
{
    public function test_onlyHiragana()
    {
        $result = (new Hiragana)->passes('field', 'ひらがな');
        $this->assertEquals(true, $result);
    }

    public function test_withSmall()
    {
        $result = (new Hiragana)->passes('field', 'ひらがなぁ');
        $this->assertEquals(true, $result);
    }

    public function test_withChohon()
    {
        $result = (new Hiragana)->passes('field', 'ひらがーな');
        $this->assertEquals(true, $result);
    }

    public function test_withKatakana()
    {
        $result = (new Hiragana)->passes('field', 'ひらガナ');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithSpace()
    {
        $result = (new Hiragana(['withSpace' => true]))->passes('field', 'ひら がな');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithSpace()
    {
        $result = (new Hiragana)->passes('field', 'ひら がな');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithMultibyteSpace()
    {
        $result = (new Hiragana(['withSpace' => true]))->passes('field', 'ひら　がな');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithMultibyteSpace()
    {
        $result = (new Hiragana)->passes('field', 'ひら　がな');
        $this->assertEquals(false, $result);
    }

    public function test_withAlpha()
    {
        $result = (new Hiragana)->passes('field', 'ひらgana');
        $this->assertEquals(false, $result);
    }

    public function test_withNumber()
    {
        $result = (new Hiragana)->passes('field', 'ひら1234');
        $this->assertEquals(false, $result);
    }

    public function test_withKanji()
    {
        $result = (new Hiragana)->passes('field', 'ひら仮名');
        $this->assertEquals(false, $result);
    }

    public function test_lastLf()
    {
        $result = (new Hiragana)->passes('field', "ひらがな\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastLfAllowedMultiline()
    {
        $result = (new Hiragana(['allowMultiline' => true]))->passes('field', "ひらがな\n");
        $this->assertEquals(true, $result);
    }

    public function test_last2Lf()
    {
        $result = (new Hiragana)->passes('field', "ひらがな\n\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastCrLf()
    {
        $result = (new Hiragana)->passes('field', "ひらがな\r\n");
        $this->assertEquals(false, $result);
    }

    public function test_includingLf()
    {
        $result = (new Hiragana)->passes('field', "ひら\nがな");
        $this->assertEquals(false, $result);
    }
}
