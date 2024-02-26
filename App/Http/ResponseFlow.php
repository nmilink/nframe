<?php

namespace App\Http;

use App\Http\ResponseMiddleware\DefaultHeaders\DefaultHeadersAbstract;
use Engine\Http\Response\ResponseInterface;
use Engine\Http\ResponseFlowInterface;

class ResponseFlow implements ResponseFlowInterface
{


    public function getFlow(ResponseInterface $request): array
    {
        return [
            DefaultHeadersAbstract::class
        ];
    }
}
