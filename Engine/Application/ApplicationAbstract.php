<?php
declare(strict_types=1);
namespace Engine\Application;

use Engine\Container\AbstractContainer;

abstract class ApplicationAbstract
{
    public function __construct(
        protected AbstractContainer $container
    ) {
        $container->setApp($this);
    }
    abstract public function make(string $abstract);

    abstract public function singleton(string $abstract, string $concrete, array $params = []);

    abstract public function add(string $abstract, string $concrete, array $params = []);
}
