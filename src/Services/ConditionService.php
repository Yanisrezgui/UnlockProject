<?php
namespace App\Services;

use App\Domain\Card;
use Doctrine\ORM\EntityManager;

final class ConditionService
{

    public function checkCanBeFlip(Card $card)
    {
        $this->flipCardStepOne($card);
    }

    //Carte retournable dès le lancement de la partie
    public function flipCardStepOne(Card $card) {
        $arrayCarteRetournable = array ('63','15','80','32','21');
        foreach($arrayCarteRetournable as $id) {
            if($card->getIdCard() == $id) {
                $card->setCanBeFlip('true');
            }
        }
    }

}