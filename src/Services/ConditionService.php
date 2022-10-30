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
        $this->flipCardStepFour($card, $cards);
        $this->flipCardStepFive($card, $cards);
        $this->flipCardStepSix($card, $cards);
        $this->flipCardStepSeven($card, $cards);
    }

    //Carte retournable dès le lancement de la partie
    public function flipCardStepOne(Card $card)
    {
        $arrayCarteRetournable = array('63','15','80','32','21');
        foreach ($arrayCarteRetournable as $id) {
            if ($card->getIdCard() == $id) {
                $card->setCanBeFlip(true);
            }
        }
    }

    //Carte 73 & 22 retournable si 15 retourné
    public function flipCardStepTwo(Card $card, array $cards)
    {
        if ($card->getIdCard() == '73' || $card->getIdCard() == '22') {
            foreach ($cards as $id) {
                if ($id->getIdCard() == '15') {
                    $card->setCanBeFlip(true);
                }
            }
        }
    }

    //Carte 85 retournable, si 22 & 63 retourné + defaussable
    public function flipCardStepThree(Card $card, array $cards)
    {
        if ($card->getIdCard() == '85') {
            foreach ($cards as $id) {
                if ($id->getIdCard() == '22') {
                    $card->setCanBeFlip(true);
                    $id->setCanBeDiscard(true);
                }
                if ($id->getIdCard() == '63') {
                    $id->setCanBeDiscard(true);
                }
            }
        }
    }

    //Carte 35 / 50 / 42 retournable si C retourné
    public function flipCardStepFour(Card $card, array $cards)
    {
        if ($card->getIdCard() == '35' || $card->getIdCard() == '50' || $card->getIdCard() == '42') {
            foreach ($cards as $id) {
                if ($id->getIdCard() == 'C') {
                    $card->setCanBeFlip(true);
                }
            }
        }
    }

    //Carte 67 retournable si 35 & 32 retourné
    public function flipCardStepFive(Card $card, array $cards)
    {
        if ($card->getIdCard() == '67') {
            foreach ($cards as $id) {
                if ($id->getIdCard() == '35') {
                    $card->setCanBeFlip(true);
                    $id->setCanBeDiscard(true);
                }
                if ($id->getIdCard() == '32') {
                    $id->setCanBeDiscard(true);
                }
            }
        }
    }

    //Carte 4 retournable si 50 retourné
    public function flipCardStepSix(Card $card, array $cards)
    {
        if ($card->getIdCard() == '4') {
            foreach ($cards as $id) {
                if ($id->getIdCard() == '50') {
                    $card->setCanBeFlip(true);
                    $id->setCanBeDiscard(true);
                }
            }
        }
    }

    //Carte M retournable si 47 retourné
    public function flipCardStepSeven(Card $card, array $cards)
    {
        if ($card->getIdCard() == 'M') {
            foreach ($cards as $id) {
                if ($id->getIdCard() == '47') {
                    $card->setCanBeFlip(true);
                }
            }
        }
    }

    //Carte C retourné, 22 & 63 defaussable
    public function canBeDiscard1769($idGame)
    {
        $card21 = $this->repository->findOneBy([
            'idCard' => '21',
            'idGame' => $idGame
        ]);
        $card80 = $this->repository->findOneBy([
            'idCard' => '80',
            'idGame' => $idGame
        ]);
        $card21->setCanBeDiscard(true);
        $card80->setCanBeDiscard(true);
        $this->em->persist($card21);
        $this->em->persist($card80);
        $this->em->flush();
    }

    //Carte 47 retourné, 4 & 73 defaussable
    public function canBeDiscard2002($idGame)
    {
        $card4 = $this->repository->findOneBy([
            'idCard' => '4',
            'idGame' => $idGame
        ]);
        $card73 = $this->repository->findOneBy([
            'idCard' => '73',
            'idGame' => $idGame
        ]);
        $card4->setCanBeDiscard(true);
        $card73->setCanBeDiscard(true);
        $this->em->persist($card4);
        $this->em->persist($card73);
        $this->em->flush();
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

    public function card60($idCard, $idGame) {
        $repository = $this->em->getRepository(Card::class);
        $card60 = $repository->findOneBy([
            'idCard' => $idCard,
            'idGame' => $idGame
        ]);
        $card42 = $repository->findOneBy([
            'idCard' => 42,
            'idGame' => $idGame
        ]);
        $card85 = $repository->findOneBy([
            'idCard' => 85,
            'idGame' => $idGame
        ]);
        if($card42->getState() == 'recto') {
            $card60->setCanBeFlip(true);
            $card42->setCanBeDiscard(true);
            $card85->setCanBeDiscard(true);
            $this->em->persist($card60);
            $this->em->flush();
        }

    }
}