<?php

namespace Shimoning\Tests\Rules;

use PHPUnit\Framework\TestCase;
use phpmock\MockBuilder;
use Illuminate\Translation\Translator;
use Illuminate\Translation\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Shimoning\LaravelUtilities\Rules\JoinedArray;
use Shimoning\LaravelUtilities\Rules\Hiragana;

class JoinedArrayTest extends TestCase
{
    public $mockTrans;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $trans = new Translator(new FileLoader(
            new Filesystem(),
            __DIR__ . '/../../resources/lang/'
        ), 'ja');
        $trans->addNamespace('laravel-utilities', __DIR__ . '/../../resources/lang/');

        $builder = new MockBuilder();
        $builder->setNamespace('Shimoning\\LaravelUtilities\\Rules')
                ->setName('trans')
                ->setFunction(
                    function ($key = null, $replace = [], $locale = null) use ($trans) {
                        return $trans->get($key, $replace, $locale);
                    }
                );
        $this->mockTrans = $builder->build();
        parent::__construct($name, $data, $dataName);
    }

    public function test_successfullyOfEmpty()
    {
        $result = (new JoinedArray)->passes('field', '');
        $this->assertEquals(true, $result);
    }

    public function test_successfullyNormallyCase()
    {
        $result = (new JoinedArray)->passes('field', 'a,b');
        $this->assertEquals(true, $result);
    }

    public function test_successfullySeparatorChanged()
    {
        $result = (new JoinedArray(null, ['separator' => '#']))->passes('field', 'a#b');
        $this->assertEquals(true, $result);
    }

    public function test_successfullyWithMin()
    {
        $result = (new JoinedArray(null, [
            'separator' => '#',
            'min' => 1,
        ]))->passes('field', 'a#b');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithMin()
    {
        // ===== trans mock ENABLED! =====
        $this->mockTrans->enable();

        $rule = (new JoinedArray(null, [
            'separator' => '#',
            'min' => 3,
        ]));
        $result = $rule->passes('field', 'a#b');
        $this->assertEquals(false, $result);
        $this->assertEquals(
            ':attribute には、配列を文字(#)で区切った 3個以上の値を含む文字列を入力してください。',
            $rule->message()
        );
    }

    public function test_successfullyWithMax()
    {
        $result = (new JoinedArray(null, [
            'separator' => '#',
            'max' => 2,
        ]))->passes('field', 'a#b');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithMax()
    {
        $rule = (new JoinedArray(null, [
            'separator' => '#',
            'max' => 3,
        ]));
        $result = $rule->passes('field', 'a#b#c#d');
        $this->assertEquals(false, $result);
        $this->assertEquals(
            ':attribute には、配列を文字(#)で区切った 3個以内の値を含む文字列を入力してください。',
            $rule->message()
        );
    }

    public function test_successfullyWithRule()
    {
        $result = (new JoinedArray('numeric'))->passes('field', '1,2,3,4');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithRule()
    {
        $rule = (new JoinedArray('numeric'));
        $result = $rule->passes('field', '1,2,c,4');
        $this->assertEquals(false, $result);
        $this->assertEquals('validation.numeric', $rule->message());
    }

    public function test_successfullyWithCustomRule()
    {
        $result = (new JoinedArray(new Hiragana))->passes('field', 'あ,い,う,え');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithCustomRule()
    {

        $rule = new JoinedArray(new Hiragana);
        $result = $rule->passes('field', 'あ,い,う,b');
        $this->assertEquals(false, $result);
        $this->assertEquals(':attribute はひらがなで入力をしてください。', $rule->message());
    }
}
