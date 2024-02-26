<?php

namespace Engine\Http\RequestValidation\Rules;

use Engine\Http\Request\RequestInterface;


class IsString extends ValidationRuleAbstract
{
    public function validate(RequestInterface $request): bool
    {
        if ($request->hasProperty($this->key)) {
            $value = $request->getProperty($this->key);
            return !is_numeric($value);
        }
        return true;
    }
    public function getFailMessage(): string
    {
        return $this->key . "_not_a_string";
    }
}
