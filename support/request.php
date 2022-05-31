<?php

use app\core\ServiceProvider;

if (!function_exists('request')) {

    function request()
    {
        return ServiceProvider::$property['request']->body;
    }
}
