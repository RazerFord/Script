<?php

namespace app\middleware;

use GuzzleHttp\Client;

class CorseMiddleware
{
    public function handle()
    {
        echo "cors error";
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Request-Methods: *");
        header("Access-Control-Request-Origin: *");
        header("Access-Control-Request-Headers: *");
        header("Access-Control-Max-Age: *");
        // header("Access-Control-Expose-Headers: *");
    }
}
