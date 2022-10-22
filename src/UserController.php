<<<<<<< HEAD
<?php
namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class UserController
{
  private $view;

  public function __construct(Twig $view, UserService $userService)
  {
    $this->view = $view;
    $this->userService = $userService;
  }

  public function test(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $user = $this->userService->signUp('test');
    return $this->view->render($response, 'hello.twig', [
      'name' => 'me',
    ]);
    return $response;
  }
}
=======
<?php
namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;


class UserController
{
  private $view;

  public function __construct(Twig $view, UserService $userService)
  {
    $this->view = $view;
    $this->userService = $userService;
  }

  public function test(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $user = $this->userService->signUp('dfghjuiyty');
    return $this->view->render($response, 'hello.twig', [
      'name' => 'me',
    ]);
    return $response;
  }
}
>>>>>>> 51e56ca710879ad2747d9c72024b4f1316db2000
