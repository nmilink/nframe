<?php

namespace App\Models\Posts;

use Engine\DB\MysqlGatewayInterface;

class RawSqlPostRepository implements PostRepositoryInterface
{
    protected $selectFields = ['id','post','created_at'];

    public function __construct(
        protected MysqlGatewayInterface $dbGateway
    ) {
    }

    public function select(int $interval): array|bool
    {
        $data = $this->dbGateway->select(
            'SELECT '.implode(',',$this->selectFields).' FROM user_posts WHERE created_at > (NOW() - INTERVAL ? DAY)',
            ['i', $interval]
        );
        if ($data === false) {
            return false;
        }
        return $data;
    }
    public function getById(int $id): array|bool
    {
        $data = $this->dbGateway->select(
            'SELECT '.implode(',',$this->selectFields).' FROM user_posts WHERE id=?',
            ['i', $id]
        );
        if ($data === false) {
            return false;
        }
        return $data[0];
    }

    public function updatePost(int $id, string $post, int $userId): bool{
        $updated = $this->dbGateway->update(
            "UPDATE user_posts SET post = ? WHERE id = ?",
            ['si', $post, $id]
        );
        if(!$updated){
            return false;
        }
        $this->dbGateway->insert(
            'INSERT INTO user_log (user_id, `action`) VALUES (?,?)',
            ['is', $userId, 'post_updated']
        );
        return true;
    }
}
