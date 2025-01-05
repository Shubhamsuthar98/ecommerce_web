<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\WelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {

        //
        // Send a welcome email to the user
        $user = $event->user;
        $email = $user->email;

        // var_dump($email);
        // die;

        // Implement your email sending logic here
        Mail::to($email)->send(new WelcomeMail($user));
    }
}
