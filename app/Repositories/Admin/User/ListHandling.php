<?php


namespace App\Repositories\Admin\User;

use App\Repositories\PagingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Admin > List User data.
 */
class ListHandling extends PagingData
{
    public function __construct(Request $request)
    {
        $this->setRequest($request);
    }

    public function validate()
    {
        $request = $this->getRequest();

        $filterRoles = ['Atlet'];
        $rules = [
            'roles' => [
                'sometimes',
                'array',
            ],
            'roles.*' => [
                'sometimes',
                'string',
                Rule::in($filterRoles),
            ],
        ];

        $messages = [
            'roles.*.in' => 'Only Allowed: ' . implode(', ', $filterRoles),
        ];

        $validated = Validator::make($request->all(), $rules, $messages)->validate();
        $this->setValidated($validated);
    }

    public function handle()
    {
        $this->validate();
        $validated = $this->getValidated();

        $searchableColumns = [
            'users.uname',
            'users.id_number',
            'users.created_at',
            'user_infos.full_addresses'
        ];
        $orderableColumns = [
            'uname',
            'id_number',
            'created_at',
            'full_addresses'
        ];

        $this->setSearchableColumns($searchableColumns);
        $this->setOrderableColumns($orderableColumns);

        $selectedColumns = [
            'users.id_number',
            'users.uname',
            'user_infos.full_addresses',
            'users.created_at',
        ];

        $query = DB::table('users')
            ->select($selectedColumns)
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->leftJoin('model_has_roles', function ($join) {
                // // $join->on('users.uuid', '=', 'model_has_roles.model_uuid');
                $join->on('users.id', '=', 'model_has_roles.model_id');
                $join->where('model_has_roles.model_type', '=', 'App\Models\User');
            })
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->whereNull('users.deleted_at');

        if (isset($validated['roles']) && !empty($validated['roles'])) {
            $query->whereIn('roles.name', $validated['roles']);
        }

        $this->paginateData($query);
        $data = $this->getData();

        // dd($data);
        // die();

        // get roles per user
        // foreach ($data as $key => $dataRow) {
        //     $dataRow->roles = DB::table('roles')
        //         ->leftJoin('model_has_roles', function ($join) {
        //             $join->on('roles.id', '=', 'model_has_roles.role_id');
        //             $join->where('model_has_roles.model_type', '=', 'App\Models\User');
        //         // })->whereIn('model_has_roles.model_uuid', [$dataRow->uuid])
        //         })->whereIn('model_has_roles.model_id', [$dataRow->id])
        //         ->get(['roles.name as name'])->pluck('name');
        //     unset($dataRow->id);
        // }

        return [
            'message' => 'User list data with pagination',
            'size' => $this->getSize(),
            'page' => $this->getPage(),
            'totalPage' => $this->getTotalPage(),
            'totalData' => $this->getTotalData(),
            'totalFiltered' => $this->getTotalFiltered(),
            'data' =>  $this->getData(),
        ];
    }
}
