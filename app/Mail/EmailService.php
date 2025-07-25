<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailService extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $type; // 'show' أو 'booking'

    public function __construct($data, $type = 'show')
    {
        $this->data = $data;
        $this->type = $type;
    }

    public function build()
    {
        $subject = $this->type === 'show' 
            ? 'New Show - ' . config('app.name') 
            : 'Booking Confirmation - ' . config('app.name');

        return $this->subject($subject)
                   ->view('emails.EmailTemplate');
    }

   

    
}
