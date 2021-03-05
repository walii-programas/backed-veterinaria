<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailClientConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /* variables */
    public $dataClient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataUserRequest)
    {
        $this->dataClient = $dataUserRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.emailClientConfirmation');
    }
}
