<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DraftOrderComplete extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * DraftOrderComplete constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('DRAFT ORDER COMPLETE <'.$this->data->name.'>')->view('emails.draft_complete_mail')->with([
            "order" =>$this->data
        ]);
    }
}
