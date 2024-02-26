<?php
namespace Engine\Http\RequestValidation\Rules;
use Engine\Http\Request\RequestInterface;


class LoggedIn extends ValidationRuleAbstract{
    public function validate(RequestInterface $request):bool{
        if ($request->hasProperty($this->key)) {
        return !is_null($request->getFromSession('userId'));
        }
        return true;
    }
    
    public function getFailMessage():string{
        return "user_not_logged_in";
    }
}