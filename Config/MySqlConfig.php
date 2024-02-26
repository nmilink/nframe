<?php
namespace Config;


class MySqlConfig implements ConfigInterface{

    public string $password;
    public string $user;
    public string $host;
    public string $dbName;

    public function __construct(){
        $data = parse_ini_file('../config.ini');
        $this->password = $data['password'];
        $this->user = $data['user'];
        $this->host = $data['host'];
        $this->dbName = $data['db_name'];

    }

    public static function load(): MySqlConfig
    {
        return new MySqlConfig();
    }
}