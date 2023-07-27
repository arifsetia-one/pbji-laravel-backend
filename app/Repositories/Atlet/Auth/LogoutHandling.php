<?php

namespace App\Repositories\Atlet\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutHandling
{
    protected $request;
    protected $user;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $user = Auth::logout();
        return $user;
    }

    public function handle()
    {
        $validated = $this->validate();

        return $validated;
    }
}
