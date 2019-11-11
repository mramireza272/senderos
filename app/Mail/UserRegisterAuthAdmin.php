<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisterAuthAdmin extends Mailable
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
        $mail = $this->view('mails.newuserauthadmin')
             ->from('territorial@sicopi.mx', 'Seguimiento Territorial')
             ->subject('Autorización para nuevo usuario');

        return $mail;
        //return $this->view('view.newuserauthadmin');
    }
}
