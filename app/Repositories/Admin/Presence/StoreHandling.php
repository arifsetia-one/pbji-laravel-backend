<?php

namespace App\Repositories\Admin\Presence;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StoreHandling {
    private $request;

    //constructor
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    //validation
    public function validate() {
        $rules = [
            'date' => [
                'required',
                'date_format:Y-m-d'
            ]
        ];

        $messages = [];
        $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
        return $validated;
    }


    //handler
    public function handle() {
        $validated = $this->validate();


        DB::beginTransaction();
        try {
            $presence = Presence::create($validated);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        $result = $presence;
        $result['message'] = 'Presence Created';
        return $result;
    }
}