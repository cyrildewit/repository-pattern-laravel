<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * Find the user with the given username.
     * @param string $slug
     * @return mixed
     */
    public function findByUsername(string $username);
}
