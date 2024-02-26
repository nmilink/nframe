<?php
namespace App\Services\FraudDetection;



class MaxMind implements FraudDetectionInterface{

    public function isFraud(string $email, string $ip):bool{
        if(strpos($email,'gmail') !== false){
            return true;
        }
        return false;
    }
}