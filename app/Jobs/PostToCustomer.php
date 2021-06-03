<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class PostToCustomer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     *
     * sends the document to email addresses
     * @return void
     */


    public $tries=3;
    public $timeout=3;
    protected $mailId;
    protected $userName;
    protected $passward;
    protected $name;
    protected $cc;

    public function __construct($mailId, $userName, $passWard, $name, $cc)
    {
        $this->mailId=$mailId;
        $this->userName=$userName;
        $this->passward=$passWard;
        $this->name=$name;
        $this->cc=$cc;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user=$this->userName;
        $pass=$this->passward;
        $name=$this->name;
        $to=$this->mailId;
        $cc=$this->cc;
        $data=['userName'=>$user,'passWard'=>$pass,'name'=>$name];
        Mail::send(
            'document_management.post_document_mail',
            $data,
            function ($message) use ($to, $name, $cc) {
                $message->from('info@iibcare.com', 'Interactive Insurance Brokers LLC');
                $message->to($to, $name);
                $message->bcc('iibcaredxb@gmail.com', 'Interactive Insurance Brokers LLC');
                if ($cc) {
                    $message->cc($cc);
                }
                $message->subject('Interactive Insurance Brokers has shared an invoice with you.');
            }
        );
    }
}
