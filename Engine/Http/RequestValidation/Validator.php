<?php
namespace Engine\Http\RequestValidation;

use Engine\Http\Request\RequestInterface;
use Engine\Http\RequestChainInterface;
use Engine\Http\Response\Response;

use Closure;
use Engine\Http\Response\ResponseInterface;

class Validator extends ValidatorAbstract implements RequestChainInterface{
    private string $message;
    public function validate(RequestInterface $request):bool{
        $rulesLoaded = $this->ruleFactory->loadRules($request->getValidationRules());
        foreach ($rulesLoaded as $key => $rs) {
            foreach($rs as $rule){
                if(!$rule->validate($request)){
                    $this->message = $rule->getFailMessage();
                    return false;
                }
            }
        }
        return true;
    }

    public function handle(RequestInterface $request, Closure $next):ResponseInterface{
        if(!$this->validate($request)){
            $response = new Response();
            $response->setStatusCode(422);
            $response->setData([
                'success'=>false,
                'error'=>$this->message
            ]);
            return $response;
        }
        return $next($request);
    }



}