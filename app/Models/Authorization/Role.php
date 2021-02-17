<?php

namespace App\Models\Authorization;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    const COLLECTION_TAG = 'roles';
    const CREATE_TAG = 'create-role';
    const SHOW_TAG = 'show-role';
    const EDIT_TAG = 'edit-role';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';

    public static $rules = [
        'name' => 'required',
        'permissionIds' => 'required|array'
    ];
    public static function getAddRules()
    {
        return array_merge(
            self::$rules,[

            ]
        );
    }
    public static function getEditRules($id)
    {
        return array_merge(
            self::$rules,[

            ]
        );
    }
}
