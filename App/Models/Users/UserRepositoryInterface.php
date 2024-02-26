<?php
namespace App\Models\Users;

interface UserRepositoryInterface{


    public function select(string $email):array|bool;

    public function store(string $email,string $password):false|int;

    public function exists($email):bool;

    public function post(int $userId,string $post): bool;

    public function authenticate(string $email,string $password): array|false;

    public function getById(int $id): array|bool;
}