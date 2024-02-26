<?php
namespace App\Services\FraudDetection;



interface FraudDetectionInterface{

    public function isFraud(string $email, string $ip):bool;
}