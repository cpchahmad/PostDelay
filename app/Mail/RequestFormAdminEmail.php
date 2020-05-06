<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestFormAdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $associate_order;
    private $order;
    private $customer;

    /**
     * RequestFormAdminEmail constructor.
     * @param $associate_order
     * @param $order
     * @param $customer
     */
    public function __construct($associate_order, $order,$customer)
    {
        $this->associate_order = $associate_order;
        $this->order = $order;
        $this->customer = $customer;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ORDER '.'<'.$this->order->order_name.'>'.' REQUIRES PAPER COPY')->view('admin_request_email')->with([
            "associate" => $this->associate_order,
            "order" =>$this->order,
            "customer" => $this->customer,
        ]);
    }
}
