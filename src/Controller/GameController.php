<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Domain\Card;
use App\Domain\Game;
use App\Services\GameService;
use App\Services\ConditionService;

class GameController
{
    private $view;
    private $em;
    private $gameService;
    private $conditionService;

    public function __construct(Twig $view, GameService $gameService, ConditionService $conditionService,EntityManager $em)  {
        $this->view = $view;
        $this->gameService = $gameService;
        $this->conditionService = $conditionService;
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

        //Supprime la partie sélectionner dans la BDD
        $repositoryGame = $this->em->getRepository(Game::class);
        $game = $repositoryGame->findOneBy([
            'end' => false,
            'idGame' => $idGame
        ]);

        //Supprime toutes les cartes associées à la partie supprimé dans la BDD
        $repositoryCard = $this->em->getRepository(Card::class);
        $cards = $repositoryCard->findBy(['idGame' => $idGame]);
        foreach($cards as $card) {
            $this->em->remove($card);
        }

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
        
        $this->conditionService->checkCanBeFlip($card);

        if ($card->getCanBeFlip() == 'true') {
            $card->setState('recto');

            $this->em->persist($card);
            $this->em->flush();
        }

        return $response
            ->withHeader('Location', '/game/'.$idGame)
            ->withStatus(302);
    }
}