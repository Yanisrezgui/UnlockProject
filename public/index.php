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

$app->get('/', \App\Controller\AccueilController::class . ':accueil');
$app->get('/credits', \App\Controller\AccueilController::class . ':credits');
$app->get('/new-game', \App\Controller\GameController::class . ':newGame');
$app->get('/game/delete-game/{idGame}', \App\Controller\GameController::class . ':deleteGame');
$app->get('/game/{id}', \App\Controller\GameController::class . ':start');
$app->get('/game/{idGame}/card/{idCard}', \App\Controller\GameController::class . ':flipCard');
$app->get('/select-game', \App\Controller\GameController::class . ':selectGame');

$app->post('/game/{idGame}/code', \App\Controller\GameController::class . ':code');
$app->post('/game/{idGame}/hint', \App\Controller\GameController::class . ':hint');
$app->post('/game/{idGame}/machine', \App\Controller\GameController::class . ':machine');


$app->run();