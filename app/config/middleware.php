<?php

use App\Middleware\ExceptionMiddleware;
use App\Middleware\ValidationMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    $app->addBodyParsingMiddleware();
    $app->add(TwigMiddleware::class);
    $app->add(ValidationMiddleware::class);
    $app->addRoutingMiddleware();
    $app->add(BasePathMiddleware::class);
    $app->add(ExceptionMiddleware::class);
};
