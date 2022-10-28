<?php

namespace App\Services;

use App\Domain\Card;
use Doctrine\ORM\EntityManager;

class ConditionService
{

    private $em;
    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Card::class);
    }

    public function checkCanBeFlip(Card $card, $idGame)
    {
        //toutes les cartes retournées
        $repository = $this->em->getRepository(Card::class);
        $cards = $repository->findBy([
            'state' => 'recto',
            'idGame' => $idGame,
        ]);

        $this->flipCardStepOne($card);
        $this->flipCardStepTwo($card, $cards);
        $this->flipCardStepThree($card, $cards);
    }

    //Carte retournable dès le lancement de la partie
    public function flipCardStepOne(Card $card) {
        $arrayCarteRetournable = array ('63','15','80','32','21');
        foreach($arrayCarteRetournable as $id) {
            if($card->getIdCard() == $id) {
                $card->setCanBeFlip(true);
            }
        }
    }

    //Carte 73 & 22 retournable si 15 retourné
    public function flipCardStepTwo(Card $card, Array $cards) {
        if($card->getIdCard() == '73' || $card->getIdCard() == '22') {
            foreach($cards as $id) {
                if($id->getIdCard() == '15') {
                    $card->setCanBeFlip(true);
                }
            }
        }
    }

    //Carte 85 retournable, si 22 & 63 retourné + defaussable
    public function flipCardStepThree(Card $card, Array $cards) {
        if($card->getIdCard() == '85') {
            foreach($cards as $id) {
                if($id->getIdCard() == '21') {
                    $card->setCanBeFlip(true);
                    $id->setCanBeDiscard(true);
                }
                if ($id->getIdCard() == '83') {
                    $id->setCanBeDiscard(true);
                }
            }
        }
    }

    //Carte C retourné, si 22 & 63 retourné + defaussable
    public function canBeDiscard($idGame) {
        $cards = $this->repository->findBy([
            'state' => 'recto',
            'idGame' => $idGame,
        ]);
        foreach($cards as $id) {
            if($id->getIdCard() == '21') {
                $id->setCanBeDiscard(true);
            }
            if ($id->getIdCard() == '80') {
                $id->setCanBeDiscard(true);
            }
        }
    }

    public function code($idCard, $idGame)
    {
        $repository = $this->em->getRepository(Card::class);
        $card = $repository->findOneBy([
            'idCard' => $idCard,
            'idGame' => $idGame
        ]);
        $card->setCanBeFlip(true);
        $this->em->persist($card);
        $this->em->flush();

        return $card;
    }
}
