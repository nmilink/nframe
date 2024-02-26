<?php



namespace Engine\Container;

use Closure;
use Engine\Application\ApplicationAbstract;
use Engine\Application\BindingsInterface;

abstract class AbstractContainer
{
    public function __construct(
        protected BindingsInterface $customizableBindings
    ){
        foreach($customizableBindings->getSingletons() as $abstract=>$concrete){
            $this->set($abstract,$concrete,true);
        }

        foreach($customizableBindings->getBindings() as $abstract=>$concrete){
            $this->set($abstract,$concrete);
        }
    }
    abstract public function resolve(string $abstract);

    abstract public function set(string $abstract, string|Closure $concrete, bool $shared = false);

    abstract public function setApp(ApplicationAbstract $app);
}
