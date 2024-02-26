<?php
namespace Engine\Http;

use Closure;
use Engine\Http\Request\RequestInterface;
use Engine\Http\Response\ResponseInterface;

interface RequestChainInterface{
    
    public function handle(RequestInterface $request, Closure $next):ResponseInterface;
}