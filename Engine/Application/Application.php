<?php

namespace Engine\Application;

class Application extends ApplicationAbstract
{
    public function make(string $abstract)
    {
        return $this->container->resolve($abstract);
    }

    public function singleton(string $abstract, string $concrete, array $params = [])
    {
        $this->container->set($abstract, $concrete, true,$params);
    }

    public function add(string $abstract, string $concrete, array $params = [])
    {
        $this->container->set($abstract, $concrete,false,$params);
    }
}
