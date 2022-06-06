<?php

namespace app\core;

class ServiceProvider
{
    public static array $property;

    public static array $middlewares;
    public static array $middlewareAnswers;

    public static function register(string $key, $object)
    {
        static::$property[$key] = $object;
    }

    public static function registerMiddleware(string $name, $object)
    {
        static::$middlewares[$name] = $object;
    }

    public static function middlewareHandle()
    {
        foreach (static::$middlewares as $name => $middleware) {
            static::$middlewareAnswers[$name] = $middleware->handle();
        }
    }
}
