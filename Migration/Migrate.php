<?php

use Config\MySqlConfig;
use Engine\DB\MysqlConnection;

require_once __DIR__.'/../AutoLoader.php';
AutoLoader::register();

$connection = (new MysqlConnection(MySqlConfig::load()))->getConnection();
$connection->query('SET FOREIGN_KEY_CHECKS=0');
$usersTable = $connection->query("DROP TABLE IF EXISTS `users`");
$usersTable = $connection->query(
    'CREATE TABLE users (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL UNIQUE,
        `password` VARCHAR(32) NOT NULL,
        posted DATETIME DEFAULT NULL,
        created_at DATETIME DEFAULT NOW()
    )'
);

$usersTable = $connection->query("DROP TABLE IF EXISTS `user_posts`");
$usersTable = $connection->query(
    'CREATE TABLE user_posts (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        user_id INT UNSIGNED,
        post VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT NOW(),
        FOREIGN KEY (user_id) REFERENCES users(id)
    )'
);

$usersTable = $connection->query("DROP TABLE IF EXISTS `user_log`");
$usersTable = $connection->query(
    'CREATE TABLE user_log (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        user_id INT UNSIGNED,
        `action` VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT NOW(),
        FOREIGN KEY (user_id) REFERENCES users(id)
    )'
);
$connection->query('SET FOREIGN_KEY_CHECKS=1');