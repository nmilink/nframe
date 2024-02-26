<?php
namespace App;

use App\EventMessages\User\UserRegisteredInterface;
use App\Services\UserNotification\UserNotificationInterface;
use Engine\Application\ApplicationAbstract;
use Engine\Application\EventHandlerInterface;
use Engine\Application\EventSubscriberInterface;
use Exception;

class EventHandler implements EventHandlerInterface{

    public function __construct(protected ApplicationAbstract $app)
    {
        
    }

    public function getEvents():array{
        return [
            'user_register'=>[
                'message_interface' => UserRegisteredInterface::class,
                'listeners'=>[
                    UserNotificationInterface::class
                ]
                ]
            ];
    }

    public function publish(string $event, mixed $message){
        
        $events = $this->getEvents();
        if(!($message instanceof $events[$event]['message_interface'])){
            throw new \Exception("Event $event passed message of incorrect type");
        }
        foreach($events[$event]['listeners'] as $l){
            $listener = $this->app->make($l);
            if(!($listener instanceof EventSubscriberInterface)){
                throw new \Exception("Listener $l to event $event does not implement the correct interface");
            }
            $listener->onEvent($message);
        }
    }
}