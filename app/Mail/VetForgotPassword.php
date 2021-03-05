<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VetForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /* variables */
    public $dataVet;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataEmailUser)
    {
        $this->dataVet = $dataEmailUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.forgotVetPassword');
    }
}
