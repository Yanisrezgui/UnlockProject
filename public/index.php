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

$app->get('/', \App\AccueilController::class . ':Accueil');
$app->get('/credits', \App\AccueilController::class . ':Credits');
$app->get('/scenario', \App\CardController::class . ':Scenario');
$app->get('/game', \App\GameController::class . ':start');
$app->get('/game/card/{id}', \App\GameController::class . ':flipCard');

$app->run();
