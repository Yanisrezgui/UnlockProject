<?php
namespace App\Services;

use App\Domain\Card;
use Doctrine\ORM\EntityManager;
use App\Domain\Game;

final class GameService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function newGame(): Game
    {
        $myGame = new Game(false, 100);
        
        $this->em->persist($myGame);
        $this->em->flush();

        $partyId = $myGame->getIdGame();

        $this->em->persist(new Card('1', "/img/card/Carte_Intro.PNG", "img/card/Carte_Explication_Jeu.PNG", "verso", "introduction", false, false, $partyId,false));
        $this->em->persist(new Card('M', "img/card/CarteM_recto.PNG", "img/card/CarteM_verso.PNG", "verso", "gris", false, false, $partyId,false));
        $this->em->persist(new Card('32', "img/card/Carte32_recto.PNG", "img/card/Carte32_verso.PNG", "verso", "rouge", false, false, $partyId,false));
        $this->em->persist(new Card('50', "img/card/Carte50_recto.PNG", "img/card/Carte50_verso.PNG", "verso", "bleu", false, false, $partyId,false));
        $this->em->persist(new Card('4', "img/card/Carte4_recto.PNG", "img/card/Carte4_verso.PNG", "verso", "bleu", false, false, $partyId,false));
        $this->em->persist(new Card('42', "img/card/Carte42_recto.PNG", "img/card/Carte42_verso.PNG", "verso", "bleu", false, false, $partyId,false));
        $this->em->persist(new Card('15', "img/card/Carte15_recto.PNG", "img/card/Carte15_verso.PNG", "verso", "gris", false, false, $partyId,false));
        $this->em->persist(new Card('63', "img/card/Carte63_recto.PNG", "img/card/Carte63_verso.PNG", "verso", "rouge", false, false, $partyId,false));
        $this->em->persist(new Card('80', "img/card/Carte80_recto.PNG", "img/card/Carte80_verso.PNG", "verso", "bleu", false, false, $partyId,false));
        $this->em->persist(new Card('22', "img/card/Carte22_recto.PNG", "img/card/Carte22_verso.PNG", "verso", "bleu", false, false, $partyId,false));
        $this->em->persist(new Card('35', "img/card/Carte35_recto.PNG", "img/card/Carte35_verso.PNG", "verso", "bleu", false, false, $partyId,false));
        $this->em->persist(new Card('21', "img/card/Carte21_recto.PNG", "img/card/Carte21_verso.PNG", "verso", "jaune", false, false, $partyId,false));
        $this->em->persist(new Card('60', "img/card/Carte60_recto.PNG", "img/card/Carte60_verso.PNG", "verso", "jaune", false, false, $partyId,false));
        $this->em->persist(new Card('85', "img/card/Carte85_recto.PNG", "img/card/Carte85_verso.PNG", "verso", "vert", false, false, $partyId,false));
        $this->em->persist(new Card('C', "img/card/CarteC_recto.PNG", "img/card/CarteC_verso.PNG", "verso", "gris", false, false, $partyId,false));
        $this->em->persist(new Card('67', "img/card/Carte67_recto.PNG", "img/card/Carte67_verso.PNG", "verso", "gris", false, false, $partyId,false));
        $this->em->persist(new Card('47', "img/card/Carte47_recto.PNG", "img/card/Carte47_verso.PNG", "verso", "gris", false, false, $partyId,false));
        $this->em->persist(new Card('73', "img/card/Carte73_recto.PNG", "img/card/Carte73_verso.PNG", "verso", "jaune", false, false, $partyId,false));
        $this->em->flush();

        return $myGame;
    }
}