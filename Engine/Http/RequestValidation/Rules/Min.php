<?php

namespace Engine\Http\RequestValidation\Rules;

use Engine\Http\Request\RequestInterface;


class Min extends ValidationRuleAbstract
{
    public function validate(RequestInterface $request): bool
    {
        if ($request->hasProperty($this->key)) {
            $value = $request->getProperty($this->key);
            if (is_numeric($value)) {
                return $value > $this->params[0];
            }
            return mb_strlen($value) > $this->params[0];
        }
        return true;
    }

    public function getFailMessage(): string
    {
        return $this->key . '_length';
    }
}
