<?php
namespace Config;


class UserNotifyConfig implements ConfigInterface{

    public readonly array $headers;

    public function __construct(){
        $data = parse_ini_file('../config.ini');
        $this->headers = array(
            'From' => $data['senderEmail'],
            'Reply-To' => $data['senderEmail'],
            'X-Mailer' => 'PHP/' . phpversion()
        );

    }

    public static function load(): UserNotifyConfig
    {
        return new UserNotifyConfig();
    }
}