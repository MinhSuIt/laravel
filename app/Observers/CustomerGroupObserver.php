<?php

namespace App\Observers;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerGroup;
use Spatie\ResponseCache\Facades\ResponseCache;

class CustomerGroupObserver
{
    /**
     * Handle the customer group "created" event.
     *
     * @param  \App\CustomerGroup  $customerGroup
     * @return void
     */
    public function created(CustomerGroup $customerGroup)
    {
        ResponseCache::clear([
            CustomerGroup::COLLECTION_TAG,
            
            Customer::COLLECTION_TAG,
            Customer::CREATE_TAG,
            Customer::EDIT_TAG,
        ]);
    }

    /**
     * Handle the customer group "updated" event.
     *
     * @param  \App\CustomerGroup  $customerGroup
     * @return void
     */
    public function updated(CustomerGroup $customerGroup)
    {
        ResponseCache::clear([
            CustomerGroup::COLLECTION_TAG,
            CustomerGroup::SHOW_TAG,
            CustomerGroup::EDIT_TAG,

            Customer::COLLECTION_TAG,
            Customer::SHOW_TAG,
            Customer::CREATE_TAG,
            Customer::EDIT_TAG,
        ]);
    }

    /**
     * Handle the customer group "deleted" event.
     *
     * @param  \App\CustomerGroup  $customerGroup
     * @return void
     */
    public function deleted(CustomerGroup $customerGroup)
    {
        ResponseCache::clear([
            CustomerGroup::COLLECTION_TAG,
            CustomerGroup::SHOW_TAG,
            CustomerGroup::EDIT_TAG,

            Customer::COLLECTION_TAG,
            Customer::SHOW_TAG,
            Customer::CREATE_TAG,
            Customer::EDIT_TAG,
        ]);
    }

    /**
     * Handle the customer group "restored" event.
     *
     * @param  \App\CustomerGroup  $customerGroup
     * @return void
     */
    public function restored(CustomerGroup $customerGroup)
    {
        //
    }

    /**
     * Handle the customer group "force deleted" event.
     *
     * @param  \App\CustomerGroup  $customerGroup
     * @return void
     */
    public function forceDeleted(CustomerGroup $customerGroup)
    {
        //
    }
}
