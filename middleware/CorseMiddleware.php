<?php

namespace app\middleware;

use GuzzleHttp\Client;

class CorseMiddleware
{
    public function handle()
    {
        echo json_encode([
            'success' => false,
            'message' => 'ggg',
            'data' => null,
        ]);

        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: *");
        // header("Access-Control-Request-Headers: *");
        // header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }
}
