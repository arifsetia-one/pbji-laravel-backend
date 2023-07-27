<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\User;

use App\Repositories\PagingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Admin > List trashed User data.
 */
class ListTrashedHandling extends PagingData
{
    public function __construct(Request $request)
    {
        $this->setRequest($request);
    }

    public function validate()
    {
        $request = $this->getRequest();

        $filterRoles = ['Administrator', 'Manajer', 'Moderator', 'Editor', 'Member', 'Contributor'];
        $rules = [
            'is_activated' => [
                'nullable',
                'boolean',
            ],
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
            'users.email',
            'user_personals.fullname',
        ];
        $orderableColumns = [
            'uname',
            'email',
            'created_at',
            'email_verified_at',
            'fullname',
        ];

        $this->setSearchableColumns($searchableColumns);
        $this->setOrderableColumns($orderableColumns);

        $selectedColumns = [
            'users.id',
            'users.uuid',
            'user_personals.fullname',
            'users.uname',
            'users.email',
            'users.email_verified_at',
            'users.is_activated',
            'users.created_at',
            // 'users.updated_at',
            'users.deleted_at',
        ];

        $query = DB::table('users')
            ->select($selectedColumns)
            ->join('user_personals', 'user_personals.user_id', '=', 'users.id')
            ->leftJoin('model_has_roles', function ($join) {
                // // $join->on('users.uuid', '=', 'model_has_roles.model_uuid');
                $join->on('users.id', '=', 'model_has_roles.model_id');
                $join->where('model_has_roles.model_type', '=', 'App\Models\User');
            })
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->whereNotNull('users.deleted_at');

        if (isset($validated['is_email_verified']) && $validated['is_email_verified'] !== '') {
            if ($validated['is_email_verified'] == true) {
                $query->whereNotNull('users.email_verified_at');
            } else {
                $query->whereNull('users.email_verified_at');
            }
        }

        if (isset($validated['is_activated']) && $validated['is_activated'] !== '') {
            $query->where('users.is_activated', '=', $validated['is_activated']);
        }

        if (isset($validated['roles']) && !empty($validated['roles'])) {
            $query->whereIn('roles.name', $validated['roles']);
        }

        $this->paginateData($query);
        $data = $this->getData();

        // get roles per user
        foreach ($data as $key => $dataRow) {
            $dataRow->roles = DB::table('roles')
                ->leftJoin('model_has_roles', function ($join) {
                    $join->on('roles.id', '=', 'model_has_roles.role_id');
                    $join->where('model_has_roles.model_type', '=', 'App\Models\User');
                // })->whereIn('model_has_roles.model_uuid', [$dataRow->uuid])
                })->whereIn('model_has_roles.model_id', [$dataRow->id])
                ->get(['roles.name as name'])->pluck('name');
            unset($dataRow->id);
        }

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
