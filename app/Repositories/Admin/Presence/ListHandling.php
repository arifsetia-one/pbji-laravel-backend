<?php

namespace App\Repositories\Admin\Presence;

use App\Repositories\PagingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ListHandling extends PagingData
{
    public function __construct(Request $request)
    {
        $this->setRequest($request);
    }

    public function validate()
    {
        $request = $this->getRequest();

        // $filterRoles = ['Administrator', 'Manajer', 'Moderator', 'Editor', 'Member', 'Contributor'];
        $rules = [

            // 'id_number' => [
            //     'nullable',
            //     'string'
            // ],
            // 'nama' => [
            //     'nullable',
            //     'string'
            // ]


            // 'is_activated' => [
            //     'nullable',
            //     'boolean',
            // ],
            // 'roles' => [
            //     'sometimes',
            //     'array',
            // ],
            // 'roles.*' => [
            //     'sometimes',
            //     'string',
            //     Rule::in($filterRoles),
            // ],
        ];

        $messages = [
            // 'roles.*.in' => 'Only Allowed: ' . implode(', ', $filterRoles),
        ];

        $validated = Validator::make($request->all(), $rules, $messages)->validate();
        $this->setValidated($validated);
    }

    public function handle()
    {
        $this->validate();
        // $validated = $this->getValidated();

        // Kolom apa saja yang bisa dipakai utk pencarian / searching
        $searchableColumns = [
            'user_id_number',
            'nama',
            'created_at'
        ];

        // Kolom apa saja yang bisa dipakai untuk pengurutan / sorting (asc/desc)
        $orderableColumns = [
            'user_id_number',
            'nama',
            'created_at'
        ];

        // Kalau bingung, cek file: app\Repositories\PagingData.php
        $this->setSearchableColumns($searchableColumns);
        $this->setOrderableColumns($orderableColumns);

        $selectedColumns = [
            'user_id_number',
            'nama',
            'created_at'
        ];

        $query = DB::table('user_has_presences')
            ->select($selectedColumns);


        $this->paginateData($query);


        return [
            'message' => 'Presence list data with pagination',
            'size' => $this->getSize(),
            'page' => $this->getPage(),
            'totalPage' => $this->getTotalPage(),
            'totalData' => $this->getTotalData(),
            'totalFiltered' => $this->getTotalFiltered(),
            'data' =>  $this->getData()
        ];
    }
    // wkwkwkwk
}
