<?php
namespace Engine\Http\RequestValidation;



interface ValidationInterface{
    
    public function getRules():array;
}