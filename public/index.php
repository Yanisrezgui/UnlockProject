<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../bootstrap.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->add(TwigMiddleware::createFromContainer($app));


$app->get('/index', function (Request $request, Response $response, $args) {
    require('index.html');

    return $response;
});

$app->get('/Card', \App\CardController::class . ':CreateCard');
$app->get('/', \App\AccueilController::class . ':Accueil');


$app->run();