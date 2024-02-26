<?php
namespace App\Models\Posts;

interface PostRepositoryInterface{


    public function select(int $interval):array|bool;

    public function getById(int $id): array|bool;

    public function updatePost(int $id, string $post, int $userId): bool;
}