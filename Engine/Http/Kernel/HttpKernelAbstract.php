<?php

namespace Engine\Http\Kernel;

use Engine\Application\ApplicationAbstract;
use Engine\Http\ControllerInvoker\AbstractInvoker;
use Engine\Http\Request\RequestInterface;
use Engine\Http\Response\ResponseInterface;

abstract class HttpKernelAbstract
{
    public function __construct(
        protected ApplicationAbstract $app
    ) {
    }

    abstract public function handle(RequestInterface $request): ResponseInterface;
    
}
