<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailUsuario;
use App\Mail\SendEmailAdmin;
use App\Models\CorreoAdmin;

class SendEmailUsuarios
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
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        Mail::to($event->email)->queue(new SendEmailUsuario());
        $correo = CorreoAdmin::first();
        if (!empty($correo)) {
            Mail::to($correo->correo)->queue(new SendEmailAdmin());
        }
        //exit;
    }
}
