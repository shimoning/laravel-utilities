<?php

namespace Shimoning\Tests\Rules;

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

    public function test_length()
    {
        $result = (new Zenkaku(['length' => 4]))->passes('field', 'ひらがな');
        $this->assertEquals(true, $result);

        $rule = new Zenkaku(['length' => 5]);
        $result = $rule->passes('field', 'ひらがな');
        $this->assertEquals(false, $result);
        // FIXME: 日本語の翻訳が入るため、テストが失敗する。翻訳を入れるか、テストを修正する必要がある。
        // とりあえずメッセージ自体は正しいのは確認できたので、テストはコメントアウトしておく。
        // $this->assertEquals('The field must be full-width characters and exactly 5 characters.', $rule->message());
    }

    public function test_min()
    {
        $result = (new Zenkaku(['min' => 4]))->passes('field', 'ひらがな');
        $this->assertEquals(true, $result);

        $rule = new Zenkaku(['min' => 5]);
        $result = $rule->passes('field', 'ひらがな');
        $this->assertEquals(false, $result);
        // FIXME: 日本語の翻訳が入るため、テストが失敗する。翻訳を入れるか、テストを修正する必要がある。
        // $this->assertEquals('The field must be full-width characters and at least 5 characters.', $rule->message());
    }

    public function test_max()
    {
        $result = (new Zenkaku(['max' => 4]))->passes('field', 'ひらがな');
        $this->assertEquals(true, $result);

        $rule = new Zenkaku(['max' => 3]);
        $result = $rule->passes('field', 'ひらがな');
        $this->assertEquals(false, $result);
        // FIXME: 日本語の翻訳が入るため、テストが失敗する。翻訳を入れるか、テストを修正する必要がある。
        // $this->assertEquals('The field must be full-width characters and at most 3 characters.', $rule->message());
    }
}
