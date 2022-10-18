<?

namespace App\Domain;

class Card{
private $number;
private $Image_recto;
private $Image_verso;
private $flip;
private $type;

public function __construct($number,$Image_recto,$Image_verso,$type){
    $this->number=$number;
    $this->Image_recto=$Image_recto;
    $this->Image_verso=$Image_verso;
    $this->flip=0;
    $this->type=$type;
}

public function getNumber(){
    return $this->number;
}

public function getImageRecto(){
    return $this->Image_recto;
}

public function getImageVerso(){
    return $this->Image_verso;
}

public function getFlipCard(){
    return $this->flip;
}

public function getType(){
    return $this->type;
}

}