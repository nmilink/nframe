<?php
namespace Config;


class DefaultHeaders implements ConfigInterface{

    public array $headers = [
        'Content-Type' => 'application/json'
    ];

    public static function load(): DefaultHeaders
    {
        return new DefaultHeaders();
    }
}