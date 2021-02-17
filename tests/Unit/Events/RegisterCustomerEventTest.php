<?php

namespace Tests\Unit\Events;

use App\Events\RegisterCustomerEvent;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterCustomerEventTest extends TestCase
{
    /**
     * test
     */
    public function test_register_customer_event()
    {
        Event::fake();
        $customer = factory(Customer::class)->make();

        event(new RegisterCustomerEvent($customer));

        // Assert that an event was dispatched...
        Event::assertDispatched(RegisterCustomerEvent::class);
    }
}
