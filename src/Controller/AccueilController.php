<?php
namespace App\Controller;

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

  public function accueil(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, 'accueil/main-menu.twig');
    return $response;
  }

  public function credits(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, 'accueil/credits.twig');
    return $response;
  }
}
