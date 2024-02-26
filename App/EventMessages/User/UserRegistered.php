<?php

namespace App\EventMessages\User;


class UserRegistered implements UserRegisteredInterface
{

    public function __construct(
        protected int $id,
        protected string $email
    ) {
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public static function load(int $id, string $email): UserRegistered
    {
        return new UserRegistered($id, $email);
    }
}
