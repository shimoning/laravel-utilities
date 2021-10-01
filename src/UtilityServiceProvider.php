<?php

namespace Shimoning\LaravelUtilities;

use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
{
    const LANG_PATH = __DIR__ . '/../resources/lang';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        // Load the default translation file
        $this->loadTranslationsFrom(self::LANG_PATH, 'shimoning-validation');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish translations
        $this->publishes([
            self::LANG_PATH => resource_path('lang'),
        ], 'translation');
    }
}
