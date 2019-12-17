<?php

namespace App\Mail;

use App\Customer;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class MailingFormEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $customer;
    protected $order;
    protected $pdf;

    /**
     * Create a new message instance.
     *
     * @param Customer $customer
     * @param Order $order
     * @param $pdf
     */
    public function __construct(Customer $customer, Order $order,$pdf)
    {
        $this->customer = $customer;
        $this->order = $order;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Shipping Label from PostDelay')->view('mailing_form')->with([
            "customer" => $this->customer,
            "order" =>$this->order
        ])->attachFromStorage($this->pdf, 'mailing_form.pdf', [
            'mime' => 'application/pdf'
        ]);

    }

}
