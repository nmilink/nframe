<?php
namespace Engine\Http\Response;



interface ResponseInterface{


    public function setData(array $data):ResponseInterface;
    public function formResponse();
    public function setHeader(string $key, string $value):ResponseInterface;
    public function setStatusCode(int $statusCode):ResponseInterface;
    
}