<?php
namespace App\Services\FraudDetection\ValidationRules;

use App\Services\FraudDetection\FraudDetectionInterface;
use Engine\Http\Request\RequestInterface;
use Engine\Http\RequestValidation\Rules\ValidationRuleAbstract;

class NotFraud extends ValidationRuleAbstract
{
    public function __construct(
        protected string $key,
        protected array $params,
        protected FraudDetectionInterface $service
    ) {
    }
    public function validate(RequestInterface $request): bool
    {
        if ($request->hasProperty($this->key)) {
            return !$this->service->isFraud($request->getProperty($this->key),$request->getIp());
        }
        return true;
    }

    public function getFailMessage(): string
    {
        return $this->key . "_is_fraud";
    }
}