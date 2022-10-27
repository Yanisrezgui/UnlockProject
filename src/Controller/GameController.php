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
    private $gameService;

    public function __construct(Twig $view, GameService $gameService, EntityManager $em)  {
        $this->view = $view;
        $this->gameService = $gameService;
        $this->em = $em;
    }

    public function newGame(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->gameService->newGame();

        $repository = $this->em->getRepository(Game::class);
        $game = $repository->findOneBy(
            array('end' => false),
            array('idGame' => 'DESC')
        );

        return $this->view->render($response, 'game/scenario.twig', [
            'game' => $game
        ]);
        return $response;
    }

    public function selectGame(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $repository = $this->em->getRepository(Game::class);
        $games = $repository->findBy([
            'end' => false
        ]);

        return $this->view->render($response, 'game/select-game.twig', [
            'games' => $games
        ]);
        return $response;
    }

    public function deleteGame(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idGame = $args['idGame'];
        $repository = $this->em->getRepository(Game::class);
        $game = $repository->findOneBy([
            'end' => false,
            'idGame' => $idGame
        ]);

        $this->em->remove($game);
        $this->em->flush();

        return $response
            ->withHeader('Location', '/select-game')
            ->withStatus(302);
    }

    public function start(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idGame = $args['id'];

        $repository = $this->em->getRepository(Card::class);
        $cards = $repository->findBy([
            'idGame' => $idGame
        ]);

        return $this->view->render($response, 'game/game.twig', [
            'cards' => $cards,
            'idGame' => $idGame
        ]);

        return $response;
    }

    public function flipCard(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idGame= $args['idGame'];
        $idCard = $args['idCard'];

        $repository = $this->em->getRepository(Card::class);
        $card = $repository->findOneBy([
            'idCard' => $idCard,
            'idGame' => $idGame
        ]);
        $card->setState('recto');

        $this->em->persist($card);
        $this->em->flush();

        return $response
            ->withHeader('Location', '/game/'.$idGame)
            ->withStatus(302);
    }
}