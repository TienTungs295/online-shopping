<?php

namespace App\Jobs;

use App\Mail\ResetPassword;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailResetPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customer_account;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customer_account)
    {
        $this->customer_account = $customer_account;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->customer_account->email)->send(new ResetPassword($this->customer_account));
    }
}
