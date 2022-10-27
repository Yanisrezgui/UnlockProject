<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Slim\Views\Twig;

class ConditionController
{
    private $view;
    private $em;

    public function __construct(Twig $view, EntityManager $em)  {
        $this->view = $view;
        $this->em = $em;
    }
}