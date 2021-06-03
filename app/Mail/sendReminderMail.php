<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $name;
    public $mailSubject;

    /**
     * Create a new message instance.
     *
     * @return void
     */ 
    public function __construct($name, $mailSubject)
    {
        $this->name=$name;
        $this->mailSubject=$mailSubject;
    }

    /**
     * Build the message.
     * 
     * @return $this
     */
    public function build()
    {
        $name=$this->name;
        $mailSubject=$this->mailSubject;
        $subject='Interactive Insurance Brokers LLC-Reminder';
        return $this->subject($subject)
        ->from('info@iibcare.com', ' Interactive Insurance Brokers LLC')
        ->view('enquiry_management.renewal_mail');
    }
}
