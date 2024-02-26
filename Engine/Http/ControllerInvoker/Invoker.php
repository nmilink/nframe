<?php
namespace Engine\Http\ControllerInvoker;

use Closure;
use Engine\Http\Request\RequestInterface;
use Engine\Http\RequestChainInterface;
use Engine\Http\Response\Response;
use Engine\Http\Response\ResponseInterface;
use ReflectionMethod;

class Invoker extends AbstractInvoker implements RequestChainInterface{ 
    
    
    public function invoke(RequestInterface $request){
        $controller = new ($request->getControllerClass())();
        $methodName = $request->getControllerMethod();
        $rMethod = new ReflectionMethod($controller,$methodName);
        $params = [];
        foreach($rMethod->getParameters() as $p){
            $name = $p->getClass()->getName();
            if($name == RequestInterface::class){
                $params[] = $request;
                continue;
            }
            $params[] = $this->app->make($name);
        }
        return $controller->$methodName(...$params);
        
    }


    public function handle(RequestInterface $request, Closure $next):ResponseInterface
    {
        $data = $this->invoke($request);
        $response = new Response();
        $response->setStatusCode(200);
        $response->setData($data);
        return $response;
    }
}