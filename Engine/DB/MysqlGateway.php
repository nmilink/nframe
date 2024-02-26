<?php
namespace Engine\DB;



class MysqlGateway implements MysqlGatewayInterface{

    public function __construct(
        protected DBConnectionInterface $connectionHandler
    )
    {
        
    }
    protected function runQuery(string $query,array $params): \mysqli_stmt|false{
        $connection = $this->connectionHandler->getConnection();
        $stmt = $connection->prepare($query);
        if($stmt === false){
            return false;
        }
        $stmt->bind_param(...$params);
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    public function select(string $query,array $params):array|false{
        $stmt = $this->runQuery($query,$params);
        if($stmt === false){
            return false;
        }
        $result = $stmt->get_result();
        $stmt->close();
        $data = [];
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function exists(string $table, string $row, string $value):bool{
        $stmt = $this->runQuery(
            "SELECT 1 FROM $table WHERE $row = ?"
            ,['s',$value]);
        if($stmt === false){
            return false;
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (bool)$row;
    }
    public function update(string $query,array $params):bool{
        $stmt = $this->runQuery($query,$params);
        if($stmt === false){
            return false;
        }
        return true;
    }
    public function insert(string $query,array $params):int|false{
        $stmt = $this->runQuery($query,$params);
        if($stmt === false){
            return false;
        }
        return $stmt->insert_id;
    }
}