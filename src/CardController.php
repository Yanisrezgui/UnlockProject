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
        $card1=new Card(1,"imagerecto","imageverso","jaune");
        return $this->view->render($response, 'Card.twig', [
            'card' => $card1,
          ]);
        return $response;
    }
}