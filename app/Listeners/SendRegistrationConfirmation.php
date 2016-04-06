<?php

namespace App\Listeners;

use App\Events\AccountRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
class SendRegistrationConfirmation implements ShouldQueue
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
        Mail::send('emails.confirmation', ['name' => $event->user->name, 'code' => $event->user->confirmation], function ($m) use ($event) {

            $m->from('nathan.barrett@dysonsphere.solutions', 'Film Festival Support');
            
            $m->to($event->user->email, $event->user->name)->subject('Film Festival Registration - The Last One You Will Ever Do');
            
        });
    }
}
