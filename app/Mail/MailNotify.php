<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $cart;
    public $order_information;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->cart = $data["cart"];
        $this->order_information = $data["order_information"];
        $this->order = $data["order"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hotro3mnhapkhau@gmail.com', 'Hỗ trợ 3M Nhập Khẩu')
            ->view('backend.email.new-order')
            ->subject('Hóa đơn mua hàng');
    }
}
