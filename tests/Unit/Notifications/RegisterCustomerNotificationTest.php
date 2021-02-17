<?php

namespace Tests\Unit\Notifications;

use App\Http\Controllers\Customer\CustomerController;
use App\Models\Category\Category;
use App\Models\Customer\Customer;
use App\Notifications\RegisterCustomerNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterCustomerNotificationTest extends TestCase
{
    protected $customerController;
    public function setup():void    
    {
        parent::setUp();
    }
    /**
     * @test
     */
    public function notification_to_all_customer_with_queue()
    {
        Notification::fake();

        $customers = factory(Customer::class,30)->make();
        $data = factory(Category::class)->make();

        Notification::send($customers, new RegisterCustomerNotification($data));

        Notification::assertSentTo(
            $customers,
            function (RegisterCustomerNotification $notification) use ($data) {
                return $notification->data->id === $data->id;
            }
        );


    }
    /**
     * @test 
    */
    public function notification_to_a_customer_with_queue()
    {
        Notification::fake();

        $customer = factory(Customer::class)->make();
        $data = factory(Category::class)->make();
        $customer->notify(new RegisterCustomerNotification($data));

        Notification::assertSentTo(
            $customer,
            function (RegisterCustomerNotification $notification) use ($data) {
                return $notification->data->id === $data->id;
            }
        );

    }
}
