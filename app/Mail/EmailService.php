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

    public $Show;
    public function __construct($Show)
    {
        $this->Show = $Show;
    }
    public function build()
    {
        return $this->subject('New Show -' . config('app.name'))
                    ->view('emails.EmailTemplate');
    }

    
}
