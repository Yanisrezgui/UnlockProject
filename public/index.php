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

$app->get('/', \App\Controller\AccueilController::class . ':Accueil');
$app->get('/credits', \App\Controller\AccueilController::class . ':Credits');
$app->get('/scenario', \App\Controller\GameController::class . ':Scenario');
$app->get('/game', \App\Controller\GameController::class . ':start');
$app->get('/game/card/{id}', \App\Controller\GameController::class . ':flipCard');

$app->run();
