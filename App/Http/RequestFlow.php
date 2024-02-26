<?php

namespace App\Http;

use Engine\DB\DBConnectionInterface;
use Engine\Http\ControllerInvoker\AbstractInvoker;
use Engine\Http\PathResolver\AbstractPathResolver;
use Engine\Http\Request\RequestInterface;
use Engine\Http\RequestFlowInterface;
use Engine\Http\RequestValidation\ValidatorAbstract;

class RequestFlow implements RequestFlowInterface
{


    public function getFlow(RequestInterface $request): array
    {
        return [
            AbstractPathResolver::class,
            DBConnectionInterface::class,
            ValidatorAbstract::class,
            AbstractInvoker::class
        ];
    }
}
