<?php

namespace Engine\Http\RequestValidation\Rules;

use Engine\Http\Request\RequestInterface;


class MatchesOther extends ValidationRuleAbstract
{
    public function validate(RequestInterface $request): bool
    {
        if ($request->hasProperty($this->key)) {
        return $request->getProperty($this->key) == $request->getProperty($this->params[0]);
        }
        return true;
    }

    public function getFailMessage():string{
        return $this->key."_mismatch";
    }
}
