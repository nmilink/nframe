<?php
namespace Engine\Http\PathResolver;

use Engine\Application\ApplicationAbstract;
use Engine\Http\RequestValidation\ValidationInterface;

abstract class AbstractPathResolver{


    public function __construct(
        protected array $controllers,
        protected ApplicationAbstract $app
    ) {
    }

    abstract protected function getControllerFromRoute(string $route, string $method);
    abstract protected function getValidatorFromMethod(string $controller, string $method):ValidationInterface|null;
    
}