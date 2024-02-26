<?php

namespace Engine\Container;

use Closure;
use Engine\Application\ApplicationAbstract;

class Container extends AbstractContainer
{



    protected array $bindings = [];
    protected array $resolved = [];
    protected ApplicationAbstract $app;

    public function setApp(ApplicationAbstract $app){
        $this->app = $app;
        
    }

    public function resolve(string $abstract)
    {
        $shared = $this->bindings[$abstract][1];
        if($shared){
            if(!isset($this->resolved[$abstract])){
                $this->resolved[$abstract] = $this->getResolved($abstract);
            }
            return $this->resolved[$abstract];
        }
        return $this->getResolved($abstract);
    }

    protected function getResolved(string $abstract){
        $concrete = $this->bindings[$abstract][0];

        if($concrete instanceof Closure){
            return $concrete($this->app);
        }
        return new $this->bindings[$abstract][0]();
    }

    public function set(string $abstract, string|Closure $concrete, bool $shared = false){
        $this->bindings[$abstract] = [$concrete,$shared];
    }
}
