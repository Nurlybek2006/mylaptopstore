<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $userMessage;

    public function __construct($name, $email, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->userMessage = $message;
    }

    public function build()
    {
        return $this->subject('Жаңа хабарлама бот-консультанттан')
                    ->view('emails.contact')
                    ->with([
                        'name' => $this->name,
                        'email' => $this->email,
                        'userMessage' => $this->userMessage
                    ]);
    }
}