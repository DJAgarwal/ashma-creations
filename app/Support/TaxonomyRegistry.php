<?php

namespace App\Support;

use InvalidArgumentException;

class TaxonomyRegistry
{
    public static function keys(): array
    {
        return array_keys(config('taxonomies', []));
    }

    public static function get(string $key): array
    {
        $config = config("taxonomies.{$key}");

        if ($config === null) {
            throw new InvalidArgumentException("Unknown taxonomy type [{$key}].");
        }

        return $config;
    }

    public static function modelClass(string $key): string
    {
        return static::get($key)['model'];
    }

    public static function label(string $key): string
    {
        return static::get($key)['label'];
    }

    public static function labelSingular(string $key): string
    {
        return static::get($key)['label_singular'] ?? static::label($key);
    }

    public static function resolve(string $key, string $slug): object
    {
        $modelClass = static::modelClass($key);

        return $modelClass::where('slug', $slug)->firstOrFail();
    }
}
