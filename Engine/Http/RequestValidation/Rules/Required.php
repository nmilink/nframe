<?php
namespace Engine\Http\RequestValidation\Rules;
use Engine\Http\Request\RequestInterface;


class Required extends ValidationRuleAbstract{
    public function validate(RequestInterface $request):bool{
        return $request->hasProperty($this->key);
    }

    public function getFailMessage():string{
        return $this->key."_missing";
    }
}