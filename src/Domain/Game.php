<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'game')]
final class Game
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id_game;

    #[Column(type: 'boolean', nullable: false)]
    private bool $end;

    #[Column(type: 'integer', nullable: false)]
    private int $score;

   
    public function getIdGame(): int
    {
        return $this->id_game;
    }

    public function getEnd(): bool
    {
        return $this->end;
    }

    public function setEnd(bool $end)
    {
        $this->end = $end;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score)
    {
        $this->score = $score;
    }
}