<?php

namespace App\Listeners;

use App\Events\RegisterCustomerEvent;
use App\Mail\CustomerRegisterMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

// 
class RegisterCustomerListener implements ShouldQueue
{
    // public $queue = 'listeners';

    // public $delay = 60;

    // public function __construct()
    // {
    //     dd(123);
    // }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RegisterCustomerEvent $event)
    {

        Mail::to('asdasd@gmail.com')->send(new CustomerRegisterMail($event->customer));
    }
}
