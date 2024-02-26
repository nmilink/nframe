<?php
namespace App\Services\UserNotification;

use App\EventMessages\User\UserRegisteredInterface;
use Config\UserNotifyConfig;
use Engine\Application\EventSubscriberInterface;

class UserNotification implements UserNotificationInterface,EventSubscriberInterface{

    public function __construct(
        protected UserNotifyConfig $config
    ){
        
    }

    public function sendAccountConfirmationEmail(string $email):bool{
        return mail($email, 'Dobro došli', 'Dobro dosli na nas sajt. Potrebno je samo da potvrdite
        email adresu ...', $this->config->headers);
    }

    public function onEvent(mixed $message){
        $this->sendAccountConfirmationEmail($message->getEmail());
    }
}