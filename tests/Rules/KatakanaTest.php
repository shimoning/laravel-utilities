<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\Katakana;

class KatakanaTest extends TestCase
{
    public function test_onlyKatakana()
    {
        $result = (new Katakana)->passes('field', 'カタカナ');
        $this->assertEquals(true, $result);
    }

    public function test_withSmall()
    {
        $result = (new Katakana)->passes('field', 'カタカナァ');
        $this->assertEquals(true, $result);
    }

    public function test_withChohon()
    {
        $result = (new Katakana)->passes('field', 'カタカーナ');
        $this->assertEquals(true, $result);
    }

    public function test_withHiragana()
    {
        $result = (new Katakana)->passes('field', 'カタかな');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithSpace()
    {
        $result = (new Katakana(['withSpace' => true]))->passes('field', 'カタ カナ');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithSpace()
    {
        $result = (new Katakana)->passes('field', 'カタ カナ');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithMultibyteSpace()
    {
        $result = (new Katakana(['withSpace' => true]))->passes('field', 'カタ　カナ');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithMultibyteSpace()
    {
        $result = (new Katakana)->passes('field', 'カタ　カナ');
        $this->assertEquals(false, $result);
    }

    public function test_withAlpha()
    {
        $result = (new Katakana)->passes('field', 'カタkana');
        $this->assertEquals(false, $result);
    }

    public function test_withNumber()
    {
        $result = (new Katakana)->passes('field', 'カタ1234');
        $this->assertEquals(false, $result);
    }

    public function test_withKanji()
    {
        $result = (new Katakana)->passes('field', 'カタ仮名');
        $this->assertEquals(false, $result);
    }

    public function test_lastLf()
    {
        $result = (new Katakana)->passes('field', "カタカナ\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastLfAllowedMultiline()
    {
        $result = (new Katakana(['allowMultiline' => true]))->passes('field', "カタカナ\n");
        $this->assertEquals(true, $result);
    }

    public function test_last2Lf()
    {
        $result = (new Katakana)->passes('field', "カタカナ\n\n");
        $this->assertEquals(false, $result);
    }

    public function test_lastCrLf()
    {
        $result = (new Katakana)->passes('field', "カタカナ\r\n");
        $this->assertEquals(false, $result);
    }

    public function test_includingLf()
    {
        $result = (new Katakana)->passes('field', "カタ\nカナ");
        $this->assertEquals(false, $result);
    }

    public function test_withoutKe()
    {
        $result = (new Katakana(['withKaKe' => false]))->passes('field', "ヶタ\nカナ");
        $this->assertEquals(false, $result);
    }

    public function test_withoutKa()
    {
        $result = (new Katakana(['withKaKe' => false]))->passes('field', "ヵタ\nカナ");
        $this->assertEquals(false, $result);
    }
}
