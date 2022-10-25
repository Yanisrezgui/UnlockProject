<?php

namespace App;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\CardController;
use App\Domain\Game;

class GameController
{
    private $view;
    private EntityManager $em;

    public function __construct(Twig $view,EntityManager $em)  {
        $this->view = $view;
        $this->em=$em;
    }

    public function start(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $myGame = new Game();
        $myGame->setEnd(false);
        $myGame->setScore(0);

        $this->em->persist($myGame);
        $this->em->flush();

        $cards = CardController::CreateCard();
        
        return $this->view->render($response, 'game/game.twig', [
            'cards' => $cards,
        ]);

        return $response;
    }
}
