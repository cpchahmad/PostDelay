<?php

namespace App\Mail;

use App\Customer;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param Customer $customer
     * @param Order $order
     */
    protected $customer;
    protected $order;

    public function __construct(Customer $customer, Order $order)
    {
        $this->customer = $customer;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email_template')->with([
            "customer" => $this->customer,
            "order" =>$this->order
        ]);
    }
}
