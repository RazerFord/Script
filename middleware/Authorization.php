<?php

namespace app\middleware;

class Authorization
{
    private string $token;

    public function __construct()
    {
        if (isset(getallheaders()['Authorization'])) {
            $this->token = getallheaders()['Authorization'];
        }
    }

    public function handle()
    {
        if ($this->except()) {
            return true;
        }

        if (empty($this->token)) {
            return false;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://idp-2.academy.smartworld.team/api/admin/get-permission',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $this->token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if (empty(json_decode($response))) {
            return false;
        }
        return json_decode($response);
    }

    public function except()
    {
        $exceptPaths = [
            '/delete-file'
        ];
        return in_array($_SERVER['REQUEST_URI'], $exceptPaths);
    }
}
