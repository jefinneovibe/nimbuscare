<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendTransferleads implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     protected $name;
     protected $email;
     protected $referencenumber;
     protected $link;
     protected $customername;
     protected $transferFrom;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name,$email,$referencenumber,$link,$customername,$transferFrom)
    {
        $this->name=$name;
        $this->email=$email;
        $this->referencenumber=$referencenumber;
        $this->link=$link;
        $this->customername=$customername;
        $this->transferFrom=$transferFrom;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name=$this->name;
        $email=$this->email;
        $referencenumber=$this->referencenumber;
        $link=$this->link;
        $customername=$this->customername;
	    $transferFrom=$this->transferFrom;
        $data=['name'=>$name,'email'=>$email,'referencenumber'=>$referencenumber,'link'=>$link,'customername'=>$customername,'transferFrom'=>$transferFrom];
        Mail::send('email_templates.send_transferleads_email', $data, function($message) use ($name,$email,$referencenumber,$link,$customername,$transferFrom)
        {
            $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
            $message->to($email)->subject('Interactive Insurance Brokers LLC - Lead Transferred');
        });
    }
}
