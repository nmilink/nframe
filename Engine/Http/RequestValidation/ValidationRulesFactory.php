<?php

namespace Engine\Http\RequestValidation;

use ReflectionMethod;

class ValidationRulesFactory extends ValidationRulesFactoryAbstract
{

    public function loadRules(array $validationRules): array
    {
        $ret = [];
        foreach ($validationRules as $key => $rules) {
            $ret[$key] = [];
            foreach ($rules as $r) {
                $parts = explode('|', $r);
                $baseRule = array_shift($parts);
                $params = $this->getParamsForRule($this->config->rules[$baseRule],$key, $parts);
                $ret[$key][] = new $this->config->rules[$baseRule](...$params);
            }
        }
        return $ret;
    }

    protected function getParamsForRule(string $rule, $key, $parts)
    {
        $rMethod = new ReflectionMethod($rule, '__construct');
        $params = [];
        foreach ($rMethod->getParameters() as $p) {
            $type = $p->getType()->__toString();
            if ($type == 'string') {
                $params[] = $key;
                continue;
            }
            if ($type == 'array') {
                $params[] = $parts;
                continue;
            }
            $name = $p->getClass()->getName();
            $params[] = $this->app->make($name);
        }
        return $params;
    }
}
