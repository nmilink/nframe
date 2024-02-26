<?php
namespace Engine\Application;



interface BindingsInterface{


    public function getBindings():array;
    public function getSingletons():array;

}