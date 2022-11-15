<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $customer_account;
    public $forgot_password_url;

    public function __construct($customer_account, $forgot_password_url)
    {
        $this->customer_account = $customer_account;
        $this->forgot_password_url = $forgot_password_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("hotro3mnhapkhau@gmail.com", "Tài khoản 3MNK")
            ->subject('3MNK - Xác nhận đặt lại mật khẩu')
            ->view('backend.email.reset-password');
    }
}
