<?php

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\CardController;

class GameController
{
    private $view;
    
    public function __construct(Twig $view)
    {
        $this->view = $view;
    }
    
    public function Game(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $cards = CardController::CreateCard();

        return $this->view->render($response, 'game/game.twig', [
            'cards' => $cards
        ]);

        return $response;
    }
}
