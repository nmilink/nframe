<?php
namespace Engine\Http\RequestValidation;


use Engine\Http\Request\RequestInterface;
use Engine\Http\RequestValidation\ValidationRulesFactoryAbstract;

abstract class ValidatorAbstract{

    public function __construct(
        protected ValidationRulesFactoryAbstract $ruleFactory,
    )
    {}
    abstract public function validate(RequestInterface $request):bool;



}