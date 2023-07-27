<?php

namespace App\Repositories\Atlet\Auth;

use App\Models\User;
use App\Models\UserHasPresence;
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

        $user = User::with(['personal', 'info'])->find(Auth::user()->id);
        // $user = UserHasPresence::where('user_id_number', $user->id_number)->count();
        // dd($user);
        // die();
        // $user = User::with(['info'])->find(Auth::user()->id);
        $user->getRoleNames();
        return $user;
    }

    public function handle()
    {
        $validated = $this->validate();

        return $validated;
    }
}
