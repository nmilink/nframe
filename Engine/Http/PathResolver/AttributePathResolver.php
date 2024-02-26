<?php

namespace Engine\Http\PathResolver;

use Closure;
use Engine\Http\PathResolver\Attributes\Route;
use Engine\Http\PathResolver\Attributes\Validator;
use Engine\Http\Request\RequestInterface;
use Engine\Http\RequestChainInterface;
use Engine\Http\RequestValidation\ValidationInterface;
use Engine\Http\Response\Response;
use Engine\Http\Response\ResponseInterface;
use ReflectionClass;
use ReflectionMethod;

class AttributePathResolver extends AbstractPathResolver implements RequestChainInterface
{

    protected function getControllerFromRoute(string $path, string $method)
    {

        foreach ($this->controllers as $controller) {
            $rController = new ReflectionClass($controller);
            foreach ($rController->getMethods() as $m) {
                $attributes = $m->getAttributes(Route::class);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    if ($route->routeMethod != $method) {
                        continue;
                    }
                    if (!$this->validateRoute($route->routePath, $path)) {
                        continue;
                    }
                    return [$controller, $m->getName()];
                }
            }
        }
        return false;
    }
    protected function validateRoute(string $route, string $target): bool
    {
        $route = ltrim(rtrim($route, '/'), '/');
        $target = ltrim(rtrim($target, '/'), '/');
        // echo($route.'<br>'.$target.'<br>');
        return $route == $target;
    }

    protected function getValidatorFromMethod(string $controller, string $method):ValidationInterface|null{
        $rMethod = new ReflectionMethod($controller,$method);
        $attributes = $rMethod->getAttributes(Validator::class);
        foreach ($attributes as $attribute) {
            $validator = $attribute->newInstance();
            $vc = $validator->validatorClass;
            return new $vc();
        }
        return null;
    }

    public function handle(RequestInterface $request, Closure $next): ResponseInterface
    {
        $cInfo = $this->getControllerFromRoute($request->getPath(), $request->getMethod());
        if($cInfo === false){
            $response = new Response();
            $response->setStatusCode(404);
            return $response;

        }
        $validator = $this->getValidatorFromMethod($cInfo[0],$cInfo[1]);
        $request->setControllerClass($cInfo[0]);
        $request->setControllerMethod($cInfo[1]);
        $request->setValidationRules(is_null($validator)?[]:$validator->getRules());
        return $next($request);
    }
}
