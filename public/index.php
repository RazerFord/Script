<?php

require(__DIR__ . '/../vendor/autoload.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use app\core\Application;
use app\core\ServiceProvider;
use app\middleware\Authorization;
use app\middleware\CorseMiddleware;

$app = new Application();

ServiceProvider::register('request', $app->router->request);

ServiceProvider::registerMiddleware('auth', new Authorization());
ServiceProvider::registerMiddleware('cors', new CorseMiddleware());

ServiceProvider::middlewareHandle();

if (ServiceProvider::$middlewareAnswers['auth'] === false) {
    echo response(false, 'user not authorize', null, 401);
    return;
}

require(__DIR__ . '/../routes/api.php');

$app->run();
