<?php
namespace Engine\DB;



interface MysqlGatewayInterface{

    public function select(string $query,array $params):array|false;
    public function exists(string $table, string $row, string $value);
    public function update(string $query,array $params):bool;
    public function insert(string $query,array $params):int|false;
}