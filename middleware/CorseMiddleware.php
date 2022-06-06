<?php

namespace app\middleware;

use GuzzleHttp\Client;

class CorseMiddleware
{
    public function handle()
    {
        // echo "cors<br>";
        header("Access-Control-Request-Origin: x-requested-with");
        header("Access-Control-Allow-Origin: x-requested-with");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Request-Headers: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        // header("Access-Control-Request-Methods: *");
        // header("Access-Control-Max-Age: *");
        // header("Access-Control-Expose-Headers: *");
    }
}
