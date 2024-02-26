<?php
namespace Engine\Http\Request;



interface RequestInterface{

    public static function capture():RequestInterface;

    public function getProperty(string $propName);
    public function hasProperty(string $propName):bool;
    public function getMethod();
    public function getPath();

    public function getIp();
    public function addToSession(string $key, mixed $value);
    public function getFromSession(string $key);

    public function setControllerClass(string $controllerClass);
    public function setControllerMethod(string $controllerMethod);
    public function setValidationRules(array $validationRules);

    public function getControllerClass();
    public function getControllerMethod();
    public function getValidationRules();
}