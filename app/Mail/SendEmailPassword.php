<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $distributor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($distributor)
    {
        //
        $this->distributor = $distributor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new-passwd')->with([
            'name' => $this->distributor['login'],
            'password' => $this->distributor['password']
        ]);;
    }
}