<?php
namespace App\EventMessages\User;


interface UserRegisteredInterface{

    public function getId():int;
    public function getEmail():string;

    public static function load(int $id,string $email):UserRegisteredInterface;
}