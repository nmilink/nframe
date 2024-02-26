<?php
namespace App\Services\UserNotification;



interface UserNotificationInterface{


    public function sendAccountConfirmationEmail(string $email):bool;
}