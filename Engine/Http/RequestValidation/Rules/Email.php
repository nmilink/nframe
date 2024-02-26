<?php

namespace Engine\Http\RequestValidation\Rules;

use Engine\Http\Request\RequestInterface;


class Email extends ValidationRuleAbstract
{
    public function validate(RequestInterface $request): bool
    {
        if ($request->hasProperty($this->key)) {
            return filter_var($request->getProperty($this->key), FILTER_VALIDATE_EMAIL);
        } else {
            return true;
        }
    }

    public function getFailMessage(): string
    {
        return $this->key . "_format";
    }
}
