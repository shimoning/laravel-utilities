<?php

namespace Shimoning\LaravelUtilities;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Arr;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Database\Query\Builder;
use Illuminate\Mail\Events\MessageSent;
use Shimoning\LaravelUtilities\Listeners\MailLogger;

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
        if (config('laravel-utilities.db_logging', true)) {
            $this->bootDbLogging();
        }

        // Logging Mail
        if (config('laravel-utilities.mail_logging', true)) {
            Event::listen(MessageSent::class, MailLogger::class);
        }

        // query macro
        $this->bootQueryMacro();
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

    /**
     * DBログのイベントリスナを設置
     *
     * @return void
     */
    public function bootDbLogging(): void
    {
        $channel = config('laravel-utilities.db_logging_channel', 'stack');

        // Query
        Event::listen(QueryExecuted::class, function ($event) use ($channel) {
            Log::channel($channel)->info("Query Time: {$event->time}s] $event->sql", $event->bindings);
        });

        // Transaction
        Event::listen(TransactionBeginning::class, function ($event) use ($channel) {
            Log::channel($channel)->info("DB: {$event->connectionName}] DB::beginTransaction()");
        });
        Event::listen(TransactionCommitted::class, function ($event) use ($channel) {
            Log::channel($channel)->info("DB: {$event->connectionName}] DB::commit()");
        });
        Event::listen(TransactionRolledBack::class, function ($event) use ($channel) {
            Log::channel($channel)->info("DB: {$event->connectionName}] DB::rollBack()");
        });
    }

    /**
     * マクロをセット
     *
     * @return void
     */
    public function bootQueryMacro(): void
    {
        Builder::macro('whereLike', function($columns, $search) {
            $this->where(function($query) use ($columns, $search) {
                foreach(Arr::wrap($columns) as $column) {
                    $query->where($column, 'LIKE', "%{$search}%");
                }
            });

            return $this;
        });

        Builder::macro('whereLikeForward', function($columns, $search) {
            $this->where(function($query) use ($columns, $search) {
                foreach(Arr::wrap($columns) as $column) {
                    $query->where($column, 'LIKE', "{$search}%");
                }
            });

            return $this;
        });

        Builder::macro('whereLikeBackward', function($columns, $search) {
            $this->where(function($query) use ($columns, $search) {
                foreach(Arr::wrap($columns) as $column) {
                    $query->where($column, 'LIKE', "%{$search}");
                }
            });

            return $this;
        });

        Builder::macro('whereInLike', function($columns, $search) {
            $this->where(function($query) use ($columns, $search) {
                foreach(Arr::wrap($columns) as $column) {
                    $query->orWhere($column, 'LIKE', "%{$search}%");
                }
            });

            return $this;
        });

        Builder::macro('whereInLikeForward', function($columns, $search) {
            $this->where(function($query) use ($columns, $search) {
                foreach(Arr::wrap($columns) as $column) {
                    $query->orWhere($column, 'LIKE', "{$search}%");
                }
            });

            return $this;
        });

        Builder::macro('whereInLikeBackward', function($columns, $search) {
            $this->where(function($query) use ($columns, $search) {
                foreach(Arr::wrap($columns) as $column) {
                    $query->orWhere($column, 'LIKE', "%{$search}");
                }
            });

            return $this;
        });
    }
}
