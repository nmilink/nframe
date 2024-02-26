<?php

namespace App\Models\Users;

use Engine\DB\MysqlGatewayInterface;

class RawSqlUserRepository implements UserRepositoryInterface
{
    protected $selectFields = ['id','email','posted','created_at'];

    public function __construct(
        protected MysqlGatewayInterface $dbGateway
    ) {
    }

    public function select(string $email): array|bool
    {
        $data = $this->dbGateway->select(
            'SELECT '.implode(',',$this->selectFields).' FROM USERS WHERE email=?',
            ['s', $email]
        );
        if ($data === false) {
            return false;
        }
        return $data[0];
    }
    public function getById(int $id): array|bool
    {
        $data = $this->dbGateway->select(
            'SELECT '.implode(',',$this->selectFields).' FROM USERS WHERE id=?',
            ['i', $id]
        );
        if ($data === false) {
            return false;
        }
        return $data[0];
    }

    public function store(string $email, string $password): false|int
    {
        $id = $this->dbGateway->insert(
            'INSERT INTO users (email, `password`) VALUES (?,?)',
            ['ss', $email, md5($password)]
        );
        if ($id === false) {
            return false;
        }
        $this->dbGateway->insert(
            'INSERT INTO user_log (user_id, `action`) VALUES (?,?)',
            ['ss', $id, 'register']
        );
        return $id;
    }
    public function authenticate(string $email,string $password): array|false{
        $data = $this->dbGateway->select(
            'SELECT '.implode(',',$this->selectFields).' FROM USERS WHERE email=? and `password`=?',
            ['ss', $email, md5($password)]
        );
        if ($data === false || empty($data)) {
            return false;
        }
        return $data[0];
    }

    public function post(int $userId,string $post): bool
    {
        $id = $this->dbGateway->insert(
            'INSERT INTO user_posts (user_id, post) VALUES (?,?)',
            ['is', $userId, $post]
        );

        if ($id === false) {
            return false;
        }
        $this->dbGateway->insert(
            'INSERT INTO user_log (user_id, `action`) VALUES (?,?)',
            ['is', $userId, 'posted']
        );
        return $this->dbGateway->update(
            "UPDATE users SET posted = NOW() WHERE id = ?",
            ['i',$userId]
        );
    }

    public function exists($email): bool
    {
        return false;
    }
}
