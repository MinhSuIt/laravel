<?php

namespace App\Observers;

use App\Models\Authorization\Role;
use App\User;
use Spatie\ResponseCache\Facades\ResponseCache;

class RoleObserver
{
    /**
     * Handle the role "created" event.
     *
     * @param  \App\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        ResponseCache::clear([
            Role::COLLECTION_TAG,

            User::CREATE_TAG,
            User::EDIT_TAG,
        ]);
    }

    /**
     * Handle the role "updated" event.
     *
     * @param  \App\Role  $role
     * @return void
     */
    public function updated(Role $role)
    {
        ResponseCache::clear([
            Role::COLLECTION_TAG,
            Role::SHOW_TAG,
            Role::EDIT_TAG,

            User::COLLECTION_TAG,
            User::CREATE_TAG,
            User::EDIT_TAG,
            User::SHOW_TAG,
        ]);
    }

    /**
     * Handle the role "deleted" event.
     *
     * @param  \App\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        ResponseCache::clear([
            Role::COLLECTION_TAG,
            Role::SHOW_TAG,
            Role::EDIT_TAG,

            User::COLLECTION_TAG,
            User::CREATE_TAG,
            User::EDIT_TAG,
            User::SHOW_TAG,
        ]);
    }

    /**
     * Handle the role "restored" event.
     *
     * @param  \App\Role  $role
     * @return void
     */
    public function restored(Role $role)
    {
        //
    }

    /**
     * Handle the role "force deleted" event.
     *
     * @param  \App\Role  $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        //
    }
}
