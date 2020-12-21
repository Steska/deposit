<?php

namespace App\Service;

use App\Model\User;

/**
 * Interface UserServiceInterface
 *
 */
interface UserServiceInterface
{
    /**
     * @param array $data
     *
     * @return User
     */
    public function create(array $data): User;

    /**
     * @param string $login
     * @param string $password
     *
     * @return bool
     */
    public function login(string $login, string $password): bool;
}
