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

      public function CreateCard(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
      {
          $card1= new Card(1, "img/Carte_Intro.PNG", "img/Carte_Explication_jeu.PNG", "Introduction");
          $cardK= new Card('K', "img/CarteK_recto.PNG", "img/CarteK_verso.PNG", "penalty");
          $card79=  new Card(79, "img/Carte79_recto.PNG", "img/Carte79_verso.PNG", "penalty");
          $cardM= new Card('M', "img/CarteM_recto.PNG", "img/CarteM_verso.PNG", "gris");
          $card32=  new Card(32, "img/Carte32_recto.PNG", "img/Carte32_verso.PNG", "rouge");
          $card50=  new Card(50, "img/Carte50_recto.PNG", "img/Carte50_verso.PNG", "bleu");
          $card4= new Card(4, "img/Carte4_recto.PNG", "img/Carte4_verso.PNG", "bleu");
          $card42=  new Card(42, "img/Carte42_recto.PNG", "img/Carte42_verso.PNG", "bleu");
          $card15=  new Card(15, "img/Carte15_recto.PNG", "img/Carte15_verso.PNG", "gris");
          $card63=  new Card(63, "img/Carte63_recto.PNG", "img/Carte63_verso.PNG", "rouge");
          $card80=  new Card(80, "img/Carte80_recto.PNG", "img/Carte80_verso.PNG", "bleu");
          $card22=  new Card(22, "img/Carte22_recto.PNG", "img/Carte22_verso.PNG", "bleu");
          $card35=  new Card(35, "img/Carte35_recto.PNG", "img/Carte35_verso.PNG", "bleu");
          $card21=  new Card(21, "img/Carte21_recto.PNG", "img/Carte21_verso.PNG", "jaune");
          $card60=  new Card(60, "img/Carte60_recto.PNG", "img/Carte60_verso.PNG", "jaune");
          $card85=  new Card(85, "img/Carte85_recto.PNG", "img/Carte85_verso.PNG", "vert");
          $cardC= new Card('C', "img/CarteC_recto.PNG", "img/CarteC_verso.PNG", "gris");
          $card67=  new Card(67, "img/Carte67_recto.PNG", "img/Carte67_verso.PNG", "gris");
          $card47=  new Card(47, "img/Carte47_recto.PNG", "img/Carte47_verso.PNG", "gris");
          $card73=  new Card(73, "img/Carte73_recto.PNG", "img/Carte73_verso.PNG", "jaune");


          $cards = array($card1,
          $cardK,
          $card79,
          $cardM,
          $card32,
          $card50,
          $card4,
          $card42,
          $card15,
          $card63,
          $card80,
          $card22,
          $card35,
          $card21,
          $card60,
          $card85,
          $cardC,
          $card67,
          $card47,
          $card73);

          return $this->view->render($response, 'Card.twig', [
              'cards' => $cards,
            ]);
          return $response;
      }
}