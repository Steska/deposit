<?php

namespace App\Service;

use App\Model\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    use RegistersUsers;

    /**
     * @inheritDoc
     */
    public function create(array $data): User
    {
        return User::create(
            [
                'login' => $data['login'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function login(string $login, string $password): bool
    {
        return Auth::attempt(['login' => $login, 'password' => $password]);
    }
}
