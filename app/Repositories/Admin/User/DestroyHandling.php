<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\User;

use App\Models\User;

/**
 * Admin > Destroy User data.
 */
class DestroyHandling
{
    private $uuid;
    private $findData;

    /**
     * Contructor.
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function validate()
    {
        // check if user is exists
        $uuid = $this->uuid;
        $this->findData = User::whereUuid($uuid)->first();

        if (!$this->findData) {
            throw new \Exception('User not found!', 404);
        }
    }

    /**
     * Handle request.
     */
    public function handle()
    {
        $this->validate();
        $user = $this->findData;
        $user->delete();

        $result = $user;
        $result['message'] = 'User deleted successfully!';
        return $result;
    }
}
