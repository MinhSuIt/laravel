<?php

namespace Tests\Unit\Jobs;

use App\Http\Controllers\Customer\CustomerController;
use App\Jobs\CustomerRegisterSendMailJob;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Queue;

class CustomerRegisterSendMailJobTest extends \Tests\TestCase
{
    protected $customerController;
    protected function setUp() :void{
        parent::setUp();
    }
    /**
     * Test queue job from customerController/store
     *
     * @test
     */
    public function test_customer_register_send_mail_job()
    {
        Queue::fake();

        // Assert that no jobs were pushed...
        Queue::assertNothingPushed();

        // // Perform order shipping... 
        $customer = factory(Customer::class)->make();

        dispatch(new CustomerRegisterSendMailJob($customer))->onQueue('emails')->delay(now()->addMinutes(1));

        // // Assert a specific type of job was pushed meeting the given truth test...
        Queue::assertPushed(function (CustomerRegisterSendMailJob $job) use ($customer) {
            return $job->customer->id === $customer->id;
        });

        // // Assert a job was pushed to a given queue...
        Queue::assertPushedOn('emails', CustomerRegisterSendMailJob::class);

        // // Assert a job was pushed twice...
        Queue::assertPushed(CustomerRegisterSendMailJob::class, 1);

    }
}
