<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactMessage;

class AdminContactNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;

    public function __construct(ContactMessage $msg)
    {
        $this->msg = $msg;
    }

    public function build()
    {
        $email = $this->subject("Pesan Baru Dari Kontak DARLI")
            ->view('emails.contact-admin');

        if ($this->msg->attachment) {
            $email->attach(storage_path('app/public/' . $this->msg->attachment));
        }

        return $email;
    }
}
