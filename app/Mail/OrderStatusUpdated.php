<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $order;
    public $comment;
    public function __construct($order,$comment)
    {
        $this->order=$order;
        $this->comment=$comment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'QSD Shop Order Status Updated',
        );
    }
    public function build()
    {
        return $this->subject("QSD Shop Order Status Updated")
                        ->view("mail.order_status_updated")
                    ->with([
                        'order'=>$this->order,
                        'comment'=>$this->comment
                    ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
