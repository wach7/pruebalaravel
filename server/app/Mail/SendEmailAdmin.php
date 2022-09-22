<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendEmailAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $usuarios = DB::table('usuarios as u')
                    ->join('categorias as c', 'u.categoria_id', 'c.id')->select('u.id', 'u.cedula', 'u.nombre', 'u.apellidos', 'u.email', 'u.direccion', 'u.celular', 'c.categoria')->get();
        return $this->subject('Aplicacion Usuarios')
                ->view('mailadmin')
                ->with([
                    'total' => count($usuarios)
                ]);;
    }
}
