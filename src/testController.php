<?php

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class testController
{
    public function test(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        echo 'test';
        return $response;
    }
}