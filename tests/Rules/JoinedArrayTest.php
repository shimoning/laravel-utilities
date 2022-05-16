<?php

use PHPUnit\Framework\TestCase;
use Shimoning\LaravelUtilities\Rules\JoinedArray;
use Shimoning\LaravelUtilities\Rules\Hiragana;

class JoinedArrayTest extends TestCase
{
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
        $result = (new JoinedArray(null, [
            'separator' => '#',
            'min' => 3,
        ]))->passes('field', 'a#b');
        $this->assertEquals(false, $result);
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
        $result = (new JoinedArray(null, [
            'separator' => '#',
            'max' => 3,
        ]))->passes('field', 'a#b#c#d');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithRule()
    {
        $result = (new JoinedArray('numeric'))->passes('field', '1,2,3,4');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithRule()
    {
        $result = (new JoinedArray('numeric'))->passes('field', '1,2,c,4');
        $this->assertEquals(false, $result);
    }

    public function test_successfullyWithCustomRule()
    {
        $result = (new JoinedArray(new Hiragana))->passes('field', 'あ,い,う,え');
        $this->assertEquals(true, $result);
    }

    public function test_failedWithCustomRule()
    {
        $result = (new JoinedArray(new Hiragana))->passes('field', 'あ,い,う,b');
        $this->assertEquals(false, $result);
    }
}
