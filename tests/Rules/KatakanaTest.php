<?php

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
}
