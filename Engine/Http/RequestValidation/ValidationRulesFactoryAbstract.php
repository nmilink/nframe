<?php
namespace Engine\Http\RequestValidation;

use Config\RequestValidation;
use Engine\Application\ApplicationAbstract;

abstract class ValidationRulesFactoryAbstract{


    public function __construct(
        protected RequestValidation $config,
        protected ApplicationAbstract $app
    ){}

    abstract public function loadRules(array $validationRules):array;
}