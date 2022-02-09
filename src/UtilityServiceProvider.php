<?php

namespace Shimoning\LaravelUtilities;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;

class UtilityServiceProvider extends ServiceProvider
{
    const TRANSLATIONS_PATH = __DIR__ . '/../resources/lang';
    const CONFIGURE_PATH    = __DIR__ . '/../config/laravel-utilities.php';

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(self::CONFIGURE_PATH, 'laravel-utilities');
    }

    /**
     * Bootstrap
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootConfig();
        $this->bootTranslation();

        // Logging DB
        if (config('laravel-utilities.database_logging', true)) {
            // Query
            DB::listen(function ($query) {
                Log::info("Query Time:{$query->time}s] $query->sql", $query->bindings);
            });

            // Transaction
            Event::listen(TransactionBeginning::class, function ($event) {
                Log::info("DB: {$event->connectionName}] DB::beginTransaction()");
            });
            Event::listen(TransactionCommitted::class, function ($event) {
                Log::info("DB: {$event->connectionName}] DB::commit()");
            });
            Event::listen(TransactionRolledBack::class, function ($event) {
                Log::info("DB: {$event->connectionName}] DB::rollBack()");
            });
        }
    }

    /**
     * 設定ファイルの公開
     *
     * @return void
     */
    public function bootConfig(): void
    {
        // Publish
        $this->publishes([
            self::CONFIGURE_PATH => config_path('laravel-utilities.php'),
        ], 'config');
    }

    /**
     * 翻訳ファイルの読み込み
     * 公開コマンド追加
     *
     * @return void
     */
    public function bootTranslation(): void
    {
        // Load
        $this->loadTranslationsFrom(self::TRANSLATIONS_PATH, 'laravel-utilities');

        // Publish
        $this->publishes([
            self::TRANSLATIONS_PATH => resource_path('lang/vendor/laravel-utilities'),
        ], 'translation');
    }
}
