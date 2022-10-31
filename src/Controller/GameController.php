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

    public function __construct(Twig $view, GameService $gameService, ConditionService $conditionService, EntityManager $em)
    {
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

        $gamesFinished = $repository->findBy([
            'end' => true
        ]);

        return $this->view->render($response, 'game/select-game.twig', [
            'games' => $games,
            'gamesFinished' => $gamesFinished
        ]);
        return $response;
    }

    public function deleteGame(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idGame = $args['idGame'];

        //Supprime la partie sélectionner dans la BDD
        $repositoryGame = $this->em->getRepository(Game::class);
        $game = $repositoryGame->findOneBy([
            'idGame' => $idGame
        ]);

        //Supprime toutes les cartes associées à la partie supprimé dans la BDD
        $repositoryCard = $this->em->getRepository(Card::class);
        $cards = $repositoryCard->findBy(['idGame' => $idGame]);
        foreach ($cards as $card) {
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
        
        $this->conditionService->checkCanBeFlip($card, $idGame);

        if ($card->getCanBeFlip() == 'true') {
            $card->setState('recto');

            $this->em->persist($card);
            $this->em->flush();
        }

        return $response
            ->withHeader('Location', '/game/'.$idGame)
            ->withStatus(302);
    }

    public function code(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $code = $request -> getParsedBody()['code'];
        $idGame= $args['idGame'];
        $isCodeExist = true;
        $card = '';

        $repository = $this->em->getRepository(Game::class);
        $game = $repository->findOneBy([
            'idGame' => $idGame
        ]);

        if ($code == 2002) {
            $card=$this->conditionService->code(47, $idGame);
            $this->conditionService->canBeDiscard2002($idGame);
        } elseif ($code == 1769) {
            $card = $this->conditionService->code('C', $idGame);
            $this->conditionService->canBeDiscard1769($idGame);
        } elseif ($code == 6504) {
            $game->setEnd(true);
            $this->em->persist($game);
            $this->em->flush();
            return $this->view->render($response, 'game/game-finished.twig',[
                'game' => $game
            ]);
        } elseif ($code == 9999) {
            return $this->view->render($response, 'game/morse.twig',[
                'idGame' => $idGame
            ]);
        } else {
            $isCodeExist = false;
        } 

        return $this->view->render($response, 'game/code.twig', [
            'card' => $card,
            'idGame' => $idGame,
            'code' => $isCodeExist
        ]);
    }

    public function hint(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idGame= $args['idGame'];
        $idTextHint = $request -> getParsedBody()['hint'];
        $textHint = '';

        $repository = $this->em->getRepository(Card::class);
        $card = $repository->findOneBy([
            'idCard' => $idTextHint,
            'idGame' => $idGame
        ]);

        if ($idTextHint == 4) {
            $textHint = "Il ressemble à la photo sur l'ordinateur. Visiblement, il avait 7 ans en 2009.";
        } elseif ($idTextHint == 21) {
            $textHint = "Il semble manquer des cartes. Et qu'essaye de nous dire le Joker ?";
        } elseif ($idTextHint == 22) {
            $textHint = "Il doit bien y avoir des vis quelque part...";
        } elseif ($idTextHint == 32) {
            $textHint = "Elle ne sert à rien sans téléphone.";
        } elseif ($idTextHint == 35) {
            $textHint = "Il faut le brancher avant toute chose...";
        } elseif ($idTextHint == 42) {
            $textHint = "Cela ressemble à la serrure de la bombe !";
        } elseif ($idTextHint == 47) {
            $textHint = "Il y a un fichier sur l'écran. Et ce fond d'écran est étrange : 1 et 0, ce sont peut être des positions ?";
        } elseif ($idTextHint == 50) {
            $textHint = "Je crois qu'il y a une photo sous le permis de conduire.";
        } elseif ($idTextHint == 60) {
            $textHint = "Peut-être que le code Morse peut vous aider à choisir ?";
        } elseif ($idTextHint == 63) {
            $textHint = "Il y a peut-être quelque chose derrière, il faut dévisser cette grille.";
        } elseif ($idTextHint == 67) {
            $textHint = "Il y a 4 groupes : d'abord Trait Trait Trait puis Point Trait Point et encore 2 autres.";
        } elseif ($idTextHint == 73) {
            $textHint = "Notre suspect semble aimer beaucoup son enfant. Le code a sûrement un rapport avec cela...";
        } elseif ($idTextHint == 80) {
            $textHint = "Il semble manquer des cartes. Et qu'essaye de nous dire le Joker ?";
        } elseif ($idTextHint == 85) {
            $textHint = "Il faut sûrement baisser certains de ces interrupteurs pour obtenir un nombre rouge, mais lesquels ?";
        }

        return $this->view->render($response, 'game/hint.twig', [
            'idGame' => $idGame,
            'textHint' => $textHint,
            'card' =>  $card
        ]);
    }

    public function machine(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface{
        
        $idGame = $args['idGame'];
        $machine = $request -> getParsedBody()['machine'];
        $textMachhine = '';
        $codeBon = true;

        $repository = $this->em->getRepository(Game::class);
        $game = $repository->findOneBy([
            'idGame' => $idGame
        ]);

        if($machine == '01100') {
            $textMachhine = "Bravo vous avez désamorcé la bombe ! Vous gagnez la carte 18, cumulez-la avec une carte bleu.";
            $this->conditionService->card60(60,$idGame);
        } else {
            $textMachhine = "Code machine faux ! Vous perdez 5 de scores";
            $codeBon = false;
            $game->setScore($game->getScore() - 5);
            $this->em->persist($game);
            $this->em->flush();
        }

        return $this->view->render($response, 'game/machine.twig', [
            'idGame' => $idGame,
            'textMachine' => $textMachhine,
            'codeBon' => $codeBon
        ]);
    }

    public function seeCard(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface{
        
        $idGame = $args['idGame'];
        $idCard = $args['idCard'];

        $repository = $this->em->getRepository(Card::class);
        $card = $repository->findOneBy([
            'idCard' => $idCard,
            'idGame' => $idGame
        ]);

        return $this->view->render($response, 'game/card.twig', [
            'idGame' => $idGame,
            'card' => $card,
        ]);
    }

    public function discardCard(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface{
        
        $idGame = $args['idGame'];
        $idCard = $args['idCard'];

        $repository = $this->em->getRepository(Card::class);
        $card = $repository->findOneBy([
            'idCard' => $idCard,
            'idGame' => $idGame
        ]);

        $card->setDiscard(true);
        $this->em->persist($card);
        $this->em->flush();

        return $response
            ->withHeader('Location', '/game/'.$idGame)
            ->withStatus(302);
    }

}
