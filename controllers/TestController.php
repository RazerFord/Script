<?php

namespace app\controllers;

class TestController
{
    public function test()
    {
        return response(true, 'suucccc', ["hello world" => 1], 201);
    }
}
