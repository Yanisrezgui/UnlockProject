<?php

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Construct\Card;

class CardController
{
  private $view;

  public function __construct(Twig $view)
  {
    $this->view = $view;
  }

  public static function CreateCard()
  {
    $card1 = new Card(1, "img/card/Carte_Intro.PNG", "img/card/Carte_Explication_Jeu.PNG", "Introduction");
    $cardK = new Card('K', "img/card/CarteK_recto.PNG", "img/card/CarteK_verso.PNG", "penalty");
    $card79 = new Card(79, "img/card/Carte79_recto.PNG", "img/card/Carte79_verso.PNG", "penalty");
    $cardM = new Card('M', "img/card/CarteM_recto.PNG", "img/card/CarteM_verso.PNG", "gris");
    $card32 = new Card(32, "img/card/Carte32_recto.PNG", "img/card/Carte32_verso.PNG", "rouge");
    $card50 = new Card(50, "img/card/Carte50_recto.PNG", "img/card/Carte50_verso.PNG", "bleu");
    $card4 = new Card(4, "img/card/Carte4_recto.PNG", "img/card/Carte4_verso.PNG", "bleu");
    $card42 = new Card(42, "img/card/Carte42_recto.PNG", "img/card/Carte42_verso.PNG", "bleu");
    $card15 = new Card(15, "img/card/Carte15_recto.PNG", "img/card/Carte15_verso.PNG", "gris");
    $card63 = new Card(63, "img/card/Carte63_recto.PNG", "img/card/Carte63_verso.PNG", "rouge");
    $card80 = new Card(80, "img/card/Carte80_recto.PNG", "img/card/Carte80_verso.PNG", "bleu");
    $card22 = new Card(22, "img/card/Carte22_recto.PNG", "img/card/Carte22_verso.PNG", "bleu");
    $card35 = new Card(35, "img/card/Carte35_recto.PNG", "img/card/Carte35_verso.PNG", "bleu");
    $card21 = new Card(21, "img/card/Carte21_recto.PNG", "img/card/Carte21_verso.PNG", "jaune");
    $card60 = new Card(60, "img/card/Carte60_recto.PNG", "img/card/Carte60_verso.PNG", "jaune");
    $card85 = new Card(85, "img/card/Carte85_recto.PNG", "img/card/Carte85_verso.PNG", "vert");
    $cardC = new Card('C', "img/card/CarteC_recto.PNG", "img/card/CarteC_verso.PNG", "gris");
    $card67 = new Card(67, "img/card/Carte67_recto.PNG", "img/card/Carte67_verso.PNG", "gris");
    $card47 = new Card(47, "img/card/Carte47_recto.PNG", "img/card/Carte47_verso.PNG", "gris");
    $card73 = new Card(73, "img/card/Carte73_recto.PNG", "img/card/Carte73_verso.PNG", "jaune");

    $cards = array(
      $card1, $cardK, $card79, $cardM, $card32, $card50, $card4, $card42,
      $card15, $card63, $card80, $card22, $card35, $card21, $card60, $card85, $cardC,
      $card67, $card47, $card73
    );

    return $cards;
  }

  public function Scenario(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, 'game/scenario.twig');
    return $response;
  }
}
