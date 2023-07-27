<?php

namespace App\Repositories\Atlet\Auth;

use App\Models\User;
use App\Models\UserHasPresence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetPresenceCountHandling
{
    protected $request;
    protected $user;


    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {

        $user = User::with(['personal'])->find(Auth::user()->id);
        $user = UserHasPresence::where('user_id_number', $user->id_number)->count();

        $presenceCount = [
            'presenceCount' => $user
        ];
        // dd($presenceCount);
        // die();
        // $user = User::with(['info'])->find(Auth::user()->id);
        return $presenceCount;
    }

    public function handle()
    {
        $validated = $this->validate();

        return $validated;
    }
}
