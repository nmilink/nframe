<?php
namespace Engine\Http\ControllerInvoker;

use Engine\Application\ApplicationAbstract;
use Engine\Http\Request\RequestInterface;
use Engine\Http\RequestChainInterface;

abstract class AbstractInvoker{
    public function __construct(
        protected ApplicationAbstract $app
    )
    {
        
    }

    abstract public function invoke(RequestInterface $request);
}