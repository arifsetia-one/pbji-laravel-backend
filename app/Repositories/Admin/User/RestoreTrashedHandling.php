<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\User;

use App\Models\User;

/**
 * Admin > Restore deleted user data.
 */
class RestoreTrashedHandling
{
    private $uuid;
    private $data;

    /**
     * Contructor.
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function validate()
    {
        $uuid = $this->uuid;
        $user = User::where('uuid', $uuid)->withTrashed()->first();

        if ($user) {
            $this->data = $user;
        } else {
            throw new \Exception('Data not found!', 404);
        }
    }

    /**
     * Handle request.
     */
    public function handle()
    {
        $this->validate();
        $user = $this->data;
        $user->restore();

        $result = $user;
        $result['message'] = 'User restored successfully!';
        return $result;
    }
}
