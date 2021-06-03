<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class IssuanceProposal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $name;
    protected $email;
    protected $customer_name;
    protected $link;
    protected $workType;
    public function __construct($name, $email, $customer_name, $link,$workType)
    {
        $this->name = $name;
        $this->email = $email;
        $this->customer_name = $customer_name;
        $this->link = $link;
        $this->workType = $workType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->name;
        $email = $this->email;
        $customer_name = $this->customer_name;
        $link = $this->link;
	    $workType = $this->workType;
        Mail::send('email_templates.insurer_approval',['email'=>$email,'customer_name'=>$customer_name,'workType'=>$workType,'link'=>$link, 'name'=>$name], function($message) use ($email,$name,$workType)
        {
            $message->from('info@iibcare.com',' Interactive Insurance Brokers LLC');
            $message->to($email, $name)->subject("Request for Approval- ".$workType);
        });
    }
}
