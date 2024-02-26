<?php

namespace Engine\Http\ResponseKernel;

use Engine\Application\ApplicationAbstract;
use Engine\Http\Request\RequestInterface;
use Engine\Http\Response\ResponseInterface;

abstract class HttpResponseKernelAbstract
{
    public function __construct(
        protected ApplicationAbstract $app
    ) {
    }

    abstract public function handle(ResponseInterface $response,RequestInterface $request): ResponseInterface;
    
}
