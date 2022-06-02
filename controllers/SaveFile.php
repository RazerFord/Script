<?php

namespace app\controllers;

class SaveFile
{
    public function save()
    {
        return response(true, 'suucccc', ["hello world" => 1], 201);
    }
}
