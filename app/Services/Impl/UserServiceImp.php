<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImp implements UserService
{
    private array $users = [
        "febri" => "rahasia"
    ];

    public function login(string $user, string $password): bool
    {
        if (!isset($this->users[$user])) {
            return  false;
        }

        $correctPassword = $this->users[$user];
        return $password ==  $correctPassword;
    }
}
