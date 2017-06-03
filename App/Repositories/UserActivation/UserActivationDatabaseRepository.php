<?php

namespace App\Repositories\UserActivation;

use Carbon\Carbon;
use App\Repositories\DatabaseRepository;

class UserActivationDatabaseRepository extends DatabaseRepository implements UserActivationRepositoryInterface
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getTable()
    {
        return 'user_activations';
    }

    /**
     * Generate an url friendly 40 chars long random token.
     *
     * @return string The generated token.
     */
    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    /**
     * Creates a new activation for an user.
     *
     * @return string A generated token.
     */
    public function createActivation($user)
    {
        $activation = $this->getActivation($user);

        if (! $activation) {
            return $this->createToken($user);
        }

        return $this->regenerateToken($user);
    }

    /**
     * Regenerate a token for an user.
     *
     * @return string A generated token.
     */
    private function regenerateToken($user)
    {
        $token = $this->getToken();

        $this->table()->where('user_id', $user->id)->update([
            'token' => $token,
            'created_at' => new Carbon(),
        ]);

        return $token;
    }

    /**
     * Creates a new activation token for an user.
     *
     * @return string A generated token.
     */
    private function createToken($user)
    {
        $token = $this->getToken();

        $this->table()->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon(),
        ]);

        return $token;
    }

    /**
     * Find an activation token with the given user.
     *
     * @return stdClass|null The stored activation token.
     */
    public function getActivation($user)
    {
        return $this->getFirstBy('user_id', $user->id);
    }

    /**
     * Find an activation entity with the given token.
     *
     * @return stdClass|null The stored activation token.
     */
    public function getActivationByToken($token)
    {
        return $this->getFirstBy('token', $token);
    }

    /**
     * Delete an activation entity with the given token.
     *
     * @return stdClass|null The stored activation token.
     */
    public function deleteActivation($token)
    {
        $this->table()->where('token', $token)->delete();
    }
}
