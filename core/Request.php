<?php

namespace app\core;

class Request
{
    public array $body = [];

    private string $path;

    public function __construct()
    {
        $uri = $_SERVER['REQUEST_URI']  ?? '/';

        $params = explode('?', $uri);

        $this->path = $params[0];

        if (isset($params[1]) && is_string($params[1])) {
            $this->buildGetParams($params[1]);
        }

        $this->buildPostParams();
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function buildGetParams(string $get)
    {
        $params = explode('&', $get);

        foreach ($params as $param) {
            $array = explode('=', $param, 2);
            if (count($array) === 2) {
                $this->body[$array[0]] = $array[1];
            }
        }
    }

    public function buildPostParams()
    {
        if (is_array($_POST)) {
            $this->body = array_merge($this->body, $_POST);
        }

        if (is_array($_FILES)) {
            $this->body = array_merge($this->body, $_FILES);
        }

        $input = json_decode(file_get_contents("php://input"), true);

        if (is_array($input)) {
            $this->body = array_merge($this->body, $input);
        }
    }
}
