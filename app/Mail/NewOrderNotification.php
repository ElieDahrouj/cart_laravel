<?php

namespace App\Mail;

use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->data = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mail@example.com', 'Mailtrap')
            ->subject('New Order')
            ->markdown('mail.admin')
            ->with([
                'firstName' => $this->data->firstName,
                'nickname' => $this->data->nickname,
                'address' => $this->data->address,
                'postal' => $this->data->postalCode,
                'city' => $this->data->city,
                'dataSession' => $this->data->dataSession,
            ]);

    }
}
