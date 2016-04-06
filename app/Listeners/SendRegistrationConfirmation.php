<?php

namespace App\Listeners;

use App\Events\AccountRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRegistrationConfirmation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccountRegistered  $event
     * @return void
     */
    public function handle(AccountRegistered $event)
    {
        //
    }
}
