<?php
namespace App\Services;

use App\Domain\Card;
use Doctrine\ORM\EntityManager;

final class ConditionService
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
                if($id->getIdCard() == '22') {
                    $card->setCanBeFlip(true);
                    $id->setCanBeDiscard(true);
                }
                if ($id->getIdCard() == '63') {
                    $id->setCanBeDiscard(true);
                }
            }
        }
    }

}