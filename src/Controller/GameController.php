<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Domain\Card;
use App\Domain\Game;
use App\Services\GameService;

class GameController
{
    private $view;
    private $em;

    public function __construct(Twig $view, GameService $gameService, EntityManager $em)  {
        $this->view = $view;
        $this->gameService = $gameService;
        $this->em = $em;
    }

    public function Scenario(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
    return $this->view->render($response, 'game/scenario.twig');
    return $response;
    }

    public function start(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->gameService->newGame();

        $repository = $this->em->getRepository(Card::class);
        $cards = $repository->findBy([
            'idGame' => 51
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
            'idGame' => 50
        ]);
        $card->setState('recto');

        $this->em->persist($card);
        $this->em->flush();

        $repository = $this->em->getRepository(Card::class);
        $cards = $repository->findBy([
            'idGame' => 50
        ]);

        return $this->view->render($response, 'game/watch-card.twig', [
            'card' => $card,
        ]);

    }
}
