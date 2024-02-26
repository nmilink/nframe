<?php
namespace Engine\Application;



interface EventSubscriberInterface{


    public function onEvent(mixed $message);
}