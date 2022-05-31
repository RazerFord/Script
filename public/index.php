<?php

require(__DIR__ . '/../vendor/autoload.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use app\core\Application;
use app\core\ServiceProvider;

$app = new Application();

ServiceProvider::register('request', $app->router->request);

require(__DIR__ . '/../routes/api.php');

$app->run();
