<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendEmailPassword;
use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Distributor Data
     * 
     * @var array
     */
    protected $distributor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($distributor)
    {
        $this->distributor = $distributor;
    }

    /**
     * Execute the job and send email
     * 
     *
     * @return void
     */
    public function handle()
    {
        $email = new SendEmailPassword($this->distributor);
        Mail::to($this->distributor['email'])->send($email);
    }
}