<?php

use app\core\ServiceProvider;

if (!function_exists('response')) {

    function response(bool $status, string $message, array $data, int $code)
    {
        http_response_code($code);
        
        return json_encode([
            'success' => $status, 
            'message' => $message,
            'data' => $data,
        ]);
    }
}
