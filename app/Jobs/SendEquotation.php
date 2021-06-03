<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendEquotation implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $pipeline_details;
	protected $email;
	protected $link;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pipeline_details,$email,$link)
    {
	    $this->pipeline_details = $pipeline_details;
	    $this->email = $email;
	    $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	    $pipeline_details = $this->pipeline_details;
	    $email = $this->email;
	    $link = $this->link;
	    Mail::send('email_templates.send_quotation_email', ['pipeline_details'=>$pipeline_details,'link'=>$link], function($message) use ($pipeline_details,$email,$link)
	    {
		    $message->from('info@iibcare.com','Interactive Insurance Brokers LLC');
		    $message->to($email,$pipeline_details['customer']['name'])->subject('Hai '.$pipeline_details['customer']['name']);
	    });
    }
}
