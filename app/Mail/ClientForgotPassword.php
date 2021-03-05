<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /* variables */
    public $dataClient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataEmailUser)
    {
        $this->dataClient = $dataEmailUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.emailClientConfirmation');
    }
}
