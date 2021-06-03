<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class sendExcel implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $email;
	protected $excel;
	protected $tab_value;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$excel,$tab_value)
    {
	    $this->email = $email;
	    $this->excel = $excel;
	    $this->tab_value = $tab_value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	    $email =$this->email;
	    $excel =$this->excel;
	    $tab_value =$this->tab_value;
	    if($tab_value=='lead')
	    {
	    	$subject='Lead List';
	    }
	    else if($tab_value=='reception')
	    {
		    $subject='Reception List';
	    }
	    else if($tab_value=='schedule')
	    {
		    $subject='Schedule for delivery/collection list';
	    }
	    else if($tab_value=='delivery')
	    {
		    $subject='Delivery list';
	    }
	    else if($tab_value=='transfer')
	    {
		    $subject='Transferred Documents';
	    }
	    else if($tab_value=='complete')
	    {
		    $subject='Completed list';
	    }
	    else if($tab_value=='employee')
	    {
		    $subject='Completed Dispatches list';
	    }
	    else if($tab_value=='recipients')
	    {
		    $subject='Recipients list';
	    }
	    else if($tab_value=='customers')
	    {
		    $subject='Customers list';
	    }
	    else{
		    $subject='';
	    }
	    Mail::send('dispatch.emails.excel',['email'=>$email,'excel'=>$excel,'subject'=>$subject], function($message) use ($email,$subject,$excel)
	    {
		    $message->from(Config::get('app_key.mail_id'),' Interactive Insurance Brokers LLC');
		    $message->to($email)->subject($subject);
		    $message->attach($excel);
	    });
    }
}
