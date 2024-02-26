<?php

namespace App\Http\ResponseMiddleware\DefaultHeaders;

use Closure;
use Engine\Http\Request\RequestInterface;
use Engine\Http\Response\ResponseInterface;
use Engine\Http\ResponseChainInterface;

class DefaultHeaders extends DefaultHeadersAbstract implements ResponseChainInterface
{


    public function handle(ResponseInterface $response, RequestInterface $request, Closure $next): ResponseInterface
    {
        foreach ($this->config->headers as $k => $v) {
            $response->setHeader($k, $v);
        }
        return $next($response, $request);
    }
}
