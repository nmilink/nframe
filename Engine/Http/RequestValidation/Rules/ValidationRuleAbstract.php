<?php
namespace Engine\Http\RequestValidation\Rules;

use Engine\Http\Request\RequestInterface;

abstract class ValidationRuleAbstract{
    public function __construct(protected string $key, protected array $params){

    }

    abstract public function validate(RequestInterface $request):bool;

    abstract public function getFailMessage():string;
}