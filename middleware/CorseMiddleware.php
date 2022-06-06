<?php

namespace app\middleware;

use GuzzleHttp\Client;

class CorseMiddleware
{
    public function handle()
    {
        header('Content-Type: application/json');

        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: *");
        // header("Access-Control-Request-Headers: *");
        // header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }
}
