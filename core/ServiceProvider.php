<?php

namespace app\core;

class ServiceProvider
{
    public static array $property;

    public static function register(string $key, $object)
    {
        static::$property[$key] = $object;
    }
}