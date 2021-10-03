# laravel-utilities
Laravel 用の便利クラス

## Install

### 通常
Packagist には登録してないので、 `LaravelUtilities.php` をDLなりコピペして好きなところに置く。

### composer で追加する
利用するプロジェクトの `composer.json` に以下を追加する。
```composer.json
"repositories": {
    "laravel-utilities": {
        "type": "vcs",
        "url": "https://github.com/shimoning/laravel-utilities.git"
    }
},
```

その後以下でインストールする。

```bash
composer require shimoning/laravel-utilities
```

## Caution
Laravel がないと動きません。
バージョンは 5.8 以上で動くと思われるが、他のバージョンについては確認中。
PHP 5.6 以上。

## Usage

### Seeders
記述予定...

### Rules
記述予定...

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

## 翻訳ファイルのカスタマイズ
```sh
php artisan vendor:publish --provider="Shimoning\LaravelUtilities\ServiceProvider" --tag=translation
```

## License
[MIT](https://opensource.org/licenses/MIT)
