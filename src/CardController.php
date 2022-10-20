<?php

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Domain\Card;

class CardController
{
    private $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

      public function test(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
      {
          
          $card1=new Card(1, "./img/lamp_on.png", "./img/magnifying_glass.png", "jaune");
          //$card1->setFlipCard();
          $card2=new Card(2, "imagerecto", "imageverso", "bleu");
          $cards = array($card1,$card2);

          return $this->view->render($response, 'Card.twig', [
              'cards' => $cards,
            ]);
          return $response;
      }
}