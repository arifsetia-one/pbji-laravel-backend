<?php

namespace App\Repositories\Admin\Presence;

use App\Models\Presence;
use App\Models\User;
use App\Models\UserHasPresence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PresenceHandling
{

    private $request;

    //constructor
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    //validation
    public function validate()
    {
        $rules = [
            'id_number' => [
                'required',
                'integer'
            ],
        ];
        $messages = [];
        $validated = Validator::make($this->request->all(), $rules, $messages)->validate();

        return $validated;
    }

    //handler
    public function handle()
    {
        $validated = $this->validate();

        // dd($validated['id_number']);
        // die;

        DB::beginTransaction();

        $data = [];

        $cekPresensi = UserHasPresence::where('user_id_number', $validated['id_number'])
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($cekPresensi) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['User ini sudah presensi']
            ]);
        } else {
            try {
                // $validated['created_by'] = auth()->user()->uuid;
                $atlet = User::where('id_number', $validated['id_number'])
                    ->select(['*', 'users.id as id'])
                    ->leftJoin('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id');
                        $join->where('model_has_roles.model_type', '=', 'App\Models\User');
                    })
                    ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->whereNull('users.deleted_at')
                    ->whereIn('roles.name', ['Atlet'])
                    ->first();
    
                // dd($atlet);
                // die;
    
    
                // $checkIdnumber = $atlet ? UserHasPresence : false;
    
                if ($atlet !== null) {
                    // User::where('id-number', $atlet->id_number)->first();
                    UserHasPresence::create([
                        'user_id_number' => $validated['id_number'],
                        'nama' => $atlet->uname
                    ]);
                } else {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'id_number' => ['Error Id Number Salah']
                    ]);
                }
    
    
                // dd($atlet->uname);
                // die;
    
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        $result = $atlet;
        $result['messsage'] = 'success';
        return $result;
    }
}
