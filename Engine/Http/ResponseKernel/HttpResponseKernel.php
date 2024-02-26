<?php

namespace Engine\Http\ResponseKernel;

use Engine\Http\Request\RequestInterface;
use Engine\Http\Response\ResponseInterface;
use Engine\Http\ResponseFlowInterface;

class HttpResponseKernel extends HttpResponseKernelAbstract
{
    private int $pointer = 0;
    private array $flow;


    public function handle(ResponseInterface $response,RequestInterface $request): ResponseInterface
    {
        $this->flow = $this->app->make(ResponseFlowInterface::class)->getFlow($response);
        $next = $this->app->make($this->flow[$this->pointer]);
        return $next->handle($response, $request,fn(ResponseInterface $r, RequestInterface $rq)=>$this->next($r,$rq));
    }

    private function next(ResponseInterface $response,RequestInterface $request){
        $this->pointer += 1;
        if($this->pointer >= count($this->flow)){
            return $response;
        }
        $next = $this->app->make($this->flow[$this->pointer]);
        
        return $next->handle($response,$request,fn(ResponseInterface $r, RequestInterface $rq)=>$this->next($r,$rq));
    }

}
