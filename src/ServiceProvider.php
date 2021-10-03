<?php

namespace Shimoning\LaravelUtilities;

use Illuminate\Support\ServiceProvider as SP;

class ServiceProvider extends SP
{
    const LANG_PATH = __DIR__ . '/../resources/lang';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Load the default translation file
        $this->loadTranslationsFrom(self::LANG_PATH, 'laravel-utilities');

        // Publish translations
        $this->publishes([
            self::LANG_PATH => resource_path('lang/vendor/laravel-utilities'),
        ], 'translation');
    }
}
