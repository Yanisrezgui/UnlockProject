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
    private string $idCard;

    #[Column(type: 'string', nullable:false)]
    private string $imgRecto;

    #[Column(type: 'string', nullable:false)]
    private string $imgVerso;

    #[Column(type: 'string', nullable: false)]
    private string $state;

    #[Column(type: 'string', nullable: false)]
    private string $type;

    #[OneToMany(targetEntity: CardController::class, mappedBy: 'card')]
    #[Column(type: 'integer', nullable:false)]
    private int $idGame;

    public function __construct($idCard, $imgRecto, $imgVerso, $state, $type, $idGame)
    {
        $this->idCard = $idCard;
        $this->imgRecto = $imgRecto;
        $this->imgVerso = $imgVerso;
        $this->state = $state;
        $this->type = $type;
        $this->idGame = $idGame;
    }
    
   public function getId(): int
    {
        return $this->id;
    }

    public function getIdCard(): string
    {
        return $this->idCard;
    }

    public function setIdCard(string $idCard)
    {
        $this->idCard = $idCard;
    }

    public function getImgRecto(): string
    {
        return $this->imgRecto;
    }

    public function setImgRecto(string $imgRecto)
    {
        $this->imgRecto = $imgRecto;
    }

    public function getImgVerso(): string
    {
        return $this->imgVerso;
    }

    public function setImgVerso(string $imgVerso)
    {
        $this->imgVerso = $imgVerso;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state){
        $this->state = $state;
    }


    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getIdGame(): int
    {
        return $this->idGame;
    }

    public function setIdGame(int $idGame){
        $this->idGame = $idGame;
    }

    public function getImage(): string
    {
        if ($this->getState() == 'recto') {
            return $this->getImgRecto();
        } else if ($this->getState() == 'verso') {
            return $this->getImgVerso();
        }
    }
}