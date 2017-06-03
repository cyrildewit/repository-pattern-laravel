<?php

namespace App\Repositories\User;

use App\Repositories\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Acl\User::class;
    }

    /**
     * Find the user with the given username.
     *
     * @param $id
     * @return mixed
     */
    public function findByUsername(string $username) {
        return $this->getFirstBy('username', $username);
    }

    /**
     * Get recent created courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getRecentCreatedUsers()
    {
        $result = $this
            ->_model
            ->orderBy('created_at', 'desc')
            ->get();

        return $result;
    }
}
