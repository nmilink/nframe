<?php
namespace Engine\Application;



interface EventHandlerInterface{


    public function getEvents():array;
    public function publish(string $event, mixed $message);
}