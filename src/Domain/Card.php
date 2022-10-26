<?php

namespace App\Domain;

use App\CardController;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity, Table(name: 'card')]
final class Card
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'string', nullable:false)]
    private string $id_card;

    #[Column(type: 'string', nullable: false)]
    private string $state;

    #[OneToMany(targetEntity: CardController::class, mappedBy: 'card')]
    #[Column(type: 'integer', nullable:false)]
    private int $id_game;
    
   
    public function getId(): int
    {
        return $this->id;
    }

    public function getIdCard(): int
    {
        return $this->id_card;
    }

    public function setIdCard(string $id_card)
    {
        $this->id_card = $id_card;
    }

    public function getState(): bool
    {
        return $this->state;
    }

    public function setState(bool $state){
        return $this->state=$state;
    }

}