<?php

namespace Shimoning\Tests\Rules;

use Shimoning\LaravelUtilities\Rules\CharByte;

class CharByteTest extends TestCase
{
    public function test_missingArgs()
    {
        $this->expectException(\InvalidArgumentException::class);
        new CharByte([]);
    }

    public function test_successfullyKanjiLength()
    {
        $result = (new CharByte(['length' => 6]))->passes('field', '漢字');
        $this->assertEquals(true, $result);
    }

    public function test_failedKanjiLength()
    {
        $result = (new CharByte(['length' => 1]))->passes('field', '漢字');
        $this->assertEquals(false, $result);
    }

    public function test_kanjiMax()
    {
        $result = (new CharByte(['max' => 6]))->passes('field', '漢字');
        $this->assertEquals(true, $result);

        $result = (new CharByte(['max' => 5]))->passes('field', '漢字');
        $this->assertEquals(false, $result);
    }

    public function test_kanjiMin()
    {
        $result = (new CharByte(['min' => 6]))->passes('field', '漢字');
        $this->assertEquals(true, $result);

        $result = (new CharByte(['min' => 7]))->passes('field', '漢字');
        $this->assertEquals(false, $result);
    }

    public function test_alphaLength()
    {
        $result = (new CharByte(['length' => 2]))->passes('field', 'ab');
        $this->assertEquals(true, $result);

        $result = (new CharByte(['length' => 1]))->passes('field', 'ab');
        $this->assertEquals(false, $result);
    }

    public function test_alphaMax()
    {
        $result = (new CharByte(['max' => 2]))->passes('field', 'ab');
        $this->assertEquals(true, $result);

        $result = (new CharByte(['max' => 1]))->passes('field', 'ab');
        $this->assertEquals(false, $result);
    }

    public function test_alphaMin()
    {
        $result = (new CharByte(['min' => 2]))->passes('field', 'ab');
        $this->assertEquals(true, $result);

        $result = (new CharByte(['min' => 3]))->passes('field', 'ab');
        $this->assertEquals(false, $result);
    }
}
