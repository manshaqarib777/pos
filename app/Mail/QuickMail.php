<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuickMail extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    /**
     Create a new message instance.

     @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     Build the message.

     @return $this
     */
    public function build()
    {
        return $this->from($this->data['from'], $this->data['fromAlly'])
            ->subject($this->data['subject'])
            ->replyTo($this->data['replyTo'], $this->data['replyToAlly'])
            ->markdown('emails.quick-mail')->with('data', $this->data);
    }
}
