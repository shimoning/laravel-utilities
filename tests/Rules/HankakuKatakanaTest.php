<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\HankakuKatakana;

class HankakuKatakanaTest extends TestCase
{
    public function test_onlyKatakana()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀｶﾅ');
        $this->assertEquals(true, $result);
    }

    public function test_withSmall()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀｶﾅｧ');
        $this->assertEquals(true, $result);
    }

    public function test_withChohon()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀｶｰﾅ');
        $this->assertEquals(true, $result);
    }

    public function test_withDakuon()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾞﾀﾞｶﾞﾅ');
        $this->assertEquals(true, $result);
    }

    public function test_withHiragana()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀかな');
        $this->assertEquals(false, $result);
    }

    public function test_withFull()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀカナ');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithSpace()
    {
        $result = (new HankakuKatakana(['withSpace' => true]))->passes('field', 'ｶﾀ ｶﾅ');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithSpace()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀ ｶﾅ');
        $this->assertEquals(false, $result);
    }

    public function test_withAlpha()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀkana');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithAlpha()
    {
        $result = (new HankakuKatakana(['withAlphabet' => true]))->passes('field', 'ｶﾀkana');
        $this->assertEquals(true, $result);
    }

    public function test_withNumber()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀ1234');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithNumber()
    {
        $result = (new HankakuKatakana(['withNumber' => true]))->passes('field', 'ｶﾀ1234');
        $this->assertEquals(true, $result);
    }

    public function test_withSymbol1()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀｶﾅ!');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithSymbol1()
    {
        $result = (new HankakuKatakana(['withSymbol' => true]))->passes('field', 'ｶﾀｶﾅ!');
        $this->assertEquals(true, $result);
    }

    public function test_withSymbol2()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀｶﾅ@');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithSymbol2()
    {
        $result = (new HankakuKatakana(['withSymbol' => true]))->passes('field', 'ｶﾀｶﾅ@');
        $this->assertEquals(true, $result);
    }

    public function test_withSymbol3()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀｶﾅ`');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithSymbol3()
    {
        $result = (new HankakuKatakana(['withSymbol' => true]))->passes('field', 'ｶﾀｶﾅ`');
        $this->assertEquals(true, $result);
    }

    public function test_withSymbol4()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀｶﾅ~');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithSymbol4()
    {
        $result = (new HankakuKatakana(['withSymbol' => true]))->passes('field', 'ｶﾀｶﾅ~');
        $this->assertEquals(true, $result);
    }

    public function test_withKigou()
    {
        $result = (new HankakuKatakana)->passes('field', '｢ｶﾀｶﾅ｣');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithKigou()
    {
        $result = (new HankakuKatakana(['withKigou' => true]))->passes('field', '｢ｶﾀｶﾅ｣');
        $this->assertEquals(true, $result);
    }

    public function test_withKanji()
    {
        $result = (new HankakuKatakana)->passes('field', 'ｶﾀ仮名');
        $this->assertEquals(false, $result);
    }

    public function test_lastLf()
    {
        $result = (new HankakuKatakana)->passes('field', "ｶﾀｶﾅ\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastLfAllowedMultiline()
    {
        $result = (new HankakuKatakana(['allowMultiline' => true]))->passes('field', "ｶﾀｶﾅ\n");
        $this->assertEquals(true, $result);
    }

    public function test_last2Lf()
    {
        $result = (new HankakuKatakana)->passes('field', "ｶﾀｶﾅ\n\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastCrLf()
    {
        $result = (new HankakuKatakana)->passes('field', "ｶﾀｶﾅ\r\n");
        $this->assertEquals(false, $result);
    }

    public function test_includingLf()
    {
        $result = (new HankakuKatakana)->passes('field', "ｶﾀ\ｶﾅ");
        $this->assertEquals(false, $result);
    }
}
