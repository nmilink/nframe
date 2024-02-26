<?php

namespace Engine\Http\Kernel;

use Engine\Http\Request\RequestInterface;
use Engine\Http\RequestFlowInterface;
use Engine\Http\Response\ResponseInterface;
use Exception;

class HttpKernel extends HttpKernelAbstract
{
    private int $pointer = 0;
    private array $flow;


    public function handle(RequestInterface $request): ResponseInterface
    {
        $this->flow = $this->app->make(RequestFlowInterface::class)->getFlow($request);
        $next = $this->app->make($this->flow[$this->pointer]);
        return $next->handle($request,fn(RequestInterface $r)=>$this->next($r));
    }

    private function next(RequestInterface $request){
        $this->pointer += 1;
        if($this->pointer >= count($this->flow)){
            throw new Exception('Request did not get handled!!!');
        }
        $next = $this->app->make($this->flow[$this->pointer]);
        
        return $next->handle($request,fn(RequestInterface $r)=>$this->next($r));
    }

}
