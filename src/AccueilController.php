<?php
namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class AccueilController
{
  private $view;

  public function __construct(Twig $view)
  {
    $this->view = $view;
  }

  public function Accueil(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, 'main-menu.twig');
    return $response;
  }
}
