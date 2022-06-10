<?php

namespace Shimoning\LaravelUtilities\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [];

    final public function __set($key, $value)
    {
        throw new \RuntimeException('this class is just readonly.');
    }
    final public function setAttribute($key, $value)
    {
        throw new \RuntimeException('this class is just readonly.');
    }
    final public static function create(array $attributes = [])
    {
        throw new \RuntimeException('this class is just readonly.');
    }
    final public static function forceCreate(array $attributes)
    {
        throw new \RuntimeException('this class is just readonly.');
    }
    final public function save(array $options = [])
    {
        throw new \RuntimeException('this class is just readonly.');
    }
    final public function delete()
    {
        throw new \RuntimeException('this class is just readonly.');
    }
    final public function push()
    {
        throw new \RuntimeException('this class is just readonly.');
    }
    final public function touch($attribute = null)
    {
        throw new \RuntimeException('this class is just readonly.');
    }
    final public function insert()
    {
        throw new \RuntimeException('this class is just readonly.');
    }
    final public function truncate()
    {
        throw new \RuntimeException('this class is just readonly.');
    }
}
