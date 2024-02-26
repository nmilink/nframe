<?php

namespace App\Http\Controllers;

use Engine\Http\PathResolver\Attributes\Route;
use Engine\Http\Request\RequestInterface;

class TestController
{



    #[Route('test', 'GET')]
    public function index(RequestInterface $request)
    {
        return [
            'hello' => 'world',
        ];
    }
}
