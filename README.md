# laravel-utilities
Laravel 用の便利クラス

## Install

### composer で追加する
利用するプロジェクトの `composer.json` に以下を追加する。
```composer.json
"repositories": {
    "shimoning/formatter": {
        "type": "vcs",
        "url": "https://github.com/shimoning/formatter.git"
    },
    "laravel-utilities": {
        "type": "vcs",
        "url": "https://github.com/shimoning/laravel-utilities.git"
    }
},
```

もしくは以下のコマンドを実行する。

```bash
composer config repositories.shimoning/formatter vcs git@github.com/shimoning/formatter.git
composer config repositories.shimoning/laravel-utilities vcs git@github.com/shimoning/laravel-utilities.git
```

その後以下でインストールする。

```bash
composer require shimoning/laravel-utilities
```

## Caution
Laravel がないと動きません。
バージョンは 5.8 以上で動くと思われるが、他のバージョンについては確認中。
PHP は 7.1 以上 (8.1 以上推奨)。

### 動作確認済み Laravel
* 5.8
* 8
* 9
* 10

## Usage

### Seeders

#### AskWithValidationTrait
シーダー実行時に、対話式で受け取った入力をバリデーションする関数を提供する。

#### TruncateAllTablesSeeder
名前の通り、全てのテーブルで truncate を実施する。
外部キー制約があっても truncate が行える。

以下のように実行する。
```cli
php artisan db:seed --class=Shimoning\\LaravelUtilities\\Seeders\\TruncateAllTablesSeeder
```

### Rules
todo: 記述予定...

#### Alpha
半角英字。デフォルトのだとマルチバイトも通るので。

#### AlphaDash
半角英字と `-` と `_` のルール。デフォルトのだとマルチバイトも通るので。

#### AlphaNum
半角英数。デフォルトのだとマルチバイトも通るので。

#### CapitalizedAlpha
半角英字の大文字。デフォルトのだとマルチバイトも通るので。

#### HexColor
16進数の色

#### Hiragana
ひらがな

#### Katakana
カタカナ

#### PhoneNumber
電話番号

#### PostalCode
郵便番号

#### Time
時間

### Logger
#### Database
.env に `DB_LOGGING` を true で設定すると、デフォルトのログチャンネルにログを残す。

#### Mail
.env に `MAIL_LOGGING` を true で設定すると、デフォルトのログチャンネルにログを残す。

### Fakers
使い方は Laravel のバージョンによって異なる。

**Laravel9**
factory クラスなど fake() を呼び出すところで、以下のようにする。
```php
$faker = fake();
$faker->addProvider(new Product($faker));

$faker->product(); // 商品1234
```

#### Product
商品


## 翻訳ファイルのカスタマイズ
```cli
php artisan vendor:publish --provider="Shimoning\LaravelUtilities\UtilityServiceProvider" --tag=translation
```

## 設定ファイルのカスタマイズ
```cli
php artisan vendor:publish --provider="Shimoning\LaravelUtilities\UtilityServiceProvider" --tag=config
```

## License
[MIT](https://opensource.org/licenses/MIT)
