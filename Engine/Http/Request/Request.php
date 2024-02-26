<?php

namespace Engine\Http\Request;



class Request implements RequestInterface
{

    private $controllerMethod;
    private $controllerClass;
    private $validationRules = [];



    public static function capture(): RequestInterface
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return new Request($_REQUEST, $_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']??'',$ip);
    }

    public function __construct(
        protected array $data,
        protected string $method,
        protected string $path,
        protected string $ip,
    ) {
    }
    public function getIp(){
        return $this->ip;
    }
    public function addToSession(string $key, mixed $value){
        $_SESSION[$key] = $value;
    }
    public function getFromSession($key){
        return $_SESSION[$key];
    }

    public function getProperty(string $propName)
    {
        return $this->data[$propName];
    }
    public function hasProperty(string $propName):bool
    {
        return isset($this->data[$propName]);
    }

    public function getMethod()
    {
        return $this->method;
    }
    public function getPath()
    {
        return $this->path;
    }

    public function setControllerClass(string $controllerClass){
        $this->controllerClass = $controllerClass;
    }
    public function setControllerMethod(string $controllerMethod){
        $this->controllerMethod = $controllerMethod;
    }
    public function setValidationRules(array $rules){
        $this->validationRules = $rules;
    }

    public function getControllerClass(){
        return $this->controllerClass;
    }
    public function getControllerMethod(){
        return $this->controllerMethod;
    }
    public function getValidationRules(){
        return $this->validationRules;
    }
}
