<?php
namespace Engine\Http;

use Closure;
use Engine\Http\Request\RequestInterface;
use Engine\Http\Response\ResponseInterface;

interface ResponseChainInterface{
    
    public function handle(ResponseInterface $response,RequestInterface $request, Closure $next):ResponseInterface;
}