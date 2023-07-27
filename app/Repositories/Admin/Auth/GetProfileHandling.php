<?php

namespace App\Repositories\Admin\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetProfileHandling
{
    protected $request;
    protected $user;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
    }

    public function handle()
    {
        $profile = auth()->user()->getProfile();
        $result = collect($profile)->toArray();
        return $result;
    }
}
