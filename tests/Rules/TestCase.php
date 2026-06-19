<?php

namespace Shimoning\Tests\Rules;

use phpmock\Mock;
use phpmock\MockBuilder;
use Illuminate\Translation\Translator;
use Illuminate\Translation\FileLoader;
use Illuminate\Filesystem\Filesystem;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public Mock $mockTrans;

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

        try {
            $this->mockTrans->enable();
        } catch (\Exception $e) {
            // すでにモックが有効な場合は無視
        }
        parent::__construct($name, $data, $dataName);
    }
}
