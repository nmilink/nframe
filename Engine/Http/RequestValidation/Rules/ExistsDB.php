<?php

namespace Engine\Http\RequestValidation\Rules;

use Engine\DB\MysqlGatewayInterface;
use Engine\Http\Request\RequestInterface;


class ExistsDB extends ValidationRuleAbstract
{
    public function __construct(
        protected string $key,
        protected array $params,
        protected MysqlGatewayInterface $gateway
    ) {
    }
    public function validate(RequestInterface $request): bool
    {
        if ($request->hasProperty($this->key)) {
            return $this->gateway->exists($this->params[0], $this->params[1], $request->getProperty($this->key));
        }
        return true;
    }

    public function getFailMessage(): string
    {
        return $this->key . "_exists";
    }
}
