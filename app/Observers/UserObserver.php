<?php

namespace App\Observers;

use App\User;
use Spatie\ResponseCache\Facades\ResponseCache;

class UserObserver
{


    public function created(User $user)
    {
        ResponseCache::clear([
            User::COLLECTION_TAG,
        ]);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        ResponseCache::clear([
            User::COLLECTION_TAG,
            User::SHOW_TAG,
            User::EDIT_TAG,
        ]);
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        ResponseCache::clear([
            User::COLLECTION_TAG,
            User::SHOW_TAG,
            User::EDIT_TAG,
        ]);
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
