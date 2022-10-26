<?php

namespace App\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Domain\Card;
use App\Domain\Game;
use App\Services\GameService;
use Doctrine\ORM\EntityManager;

class GameController
{
    private $view;
    private $em;

    public function __construct(Twig $view, GameService $gameService,EntityManager $em)  {
        $this->view = $view;
        $this->gameService = $gameService;
        $this->em=$em;
    }

    public function Scenario(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
    return $this->view->render($response, 'game/scenario.twig');
    return $response;
    }

    public function start(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        //$this->gameService->newGame();

        $repository=$this->em->getRepository(Card::class);
        $cards=$repository->findBy([
            'idGame' => 11
        ]);

        return $this->view->render($response, 'game/game.twig', [
            'cards' => $cards,
        ]);

        return $response;
    }

    public function flipCard(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idCard = $args['id'];

        $repository = $this->em->getRepository(Card::class);
        $card = $repository->findOneBy([
            'idCard' => $idCard,
            'idGame' => 11
        ]);
        $card->setState('recto');

        $this->em->persist($card);
        $this->em->flush();
 
        return $response
          ->withHeader('Location', '/game')
          ->withStatus(302);


    }
}