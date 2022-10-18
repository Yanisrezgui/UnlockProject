<?php

namespace App;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\Card;

class CardController
{
    public function test(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        echo 'test';
        return $response;
    }
}