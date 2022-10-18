<?php


class Tire
{
    private $season;
    private $height;
    private $width;
    private $diameter;
    private $maxpressure;
    private $currentpressure;

    public function setSeason($season){
        $this->season=$season;
    }

    public function __construct($season='été')
    {
        $this->season = $season;
        $this->height="12";
        $this->width="274";
        $this->diameter = "24";
        $this->maxpressure="8";
        $this->currentpressure="2.4";
    }
}

class Wheel
{
    private $diameter;
    private $material;
    private $brand;

    private Tire $tire;

    public function __construct(Tire $tire)
    {
        $this->diameter = 25;
        $this->material="titanium";
        $this->brand="Pirelli";
        $this->tire = $tire;
    }
}


class Car
{
    private $wheel;

    public function __construct(Tire $tire = new Tire())
    {
        $this->wheels = [new Wheel($tire), new Wheel($tire) ,new Wheel($tire), new Wheel($tire)];
    }
}

$car = new Car();

$pneuHiver = new Tire("hiver");
$car = new Car($pneuHiver);