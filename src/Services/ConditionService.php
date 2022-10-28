<?php
namespace App\Services;

use App\Domain\Card;
use Doctrine\ORM\EntityManager;

class ConditionService
{

    private $em;

    public function __construct(EntityManager $em)  {
        $this->em = $em;
    }

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


    public function code($idCard, $idGame){
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