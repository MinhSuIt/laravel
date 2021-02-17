<?php

namespace Tests\Unit\Mail;

use App\Http\Controllers\Customer\CustomerController;
use App\Mail\CustomerRegisterMail;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Mail;
use \Tests\TestCase;

class CustomerRegisterMailTest extends TestCase
{
    /**
     * @test
     * 
     */
    public function mailQueueJob()
    {
        Mail::fake();
        $customer = factory(Customer::class)->make();
        $mailable = new CustomerRegisterMail($customer);
        $this->assertInstanceOf(CustomerRegisterMail::class, $mailable->build());     
        Mail::to('asdasd@gmail.com')->queue(new CustomerRegisterMail($customer));
        Mail::assertQueued(CustomerRegisterMail::class, function ($mail) use ($customer) {
            return $mail->customer->id === $customer->id;
        });
    }
}
