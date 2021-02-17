<?php

namespace App\Models\Authorization;

use Spatie\Permission\Models\Permission as ModelsPermission;


class Permission extends ModelsPermission
{
    const COLLECTION_TAG = 'permissions';
    // const CREATE_TAG = 'create-permission';
    // const SHOW_TAG = 'show-permission';
    // const EDIT_TAG = 'edit-permission';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    // const CREATE_TAG_TIME = 'cacheResponse:300';
    // const SHOW_TAG_TIME = 'cacheResponse:300';
    // const EDIT_TAG_TIME = 'cacheResponse:300';
}
