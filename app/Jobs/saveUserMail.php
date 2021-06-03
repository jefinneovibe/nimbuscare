<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;


class saveUserMail implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    protected $user_details;
    protected $password; 
    protected $role;
    protected $loginLink;
    /** 
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$user_details,$password,$role,$loginLink)
    {
	    $this->email = $email;
	    $this->user_details = $user_details;
	    $this->password = $password;
	    $this->role = $role;
	    $this->loginLink = $loginLink;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	    $email = $this->email;
	    $user_details = $this->user_details;
	    $password = $this->password;
	    $role = $this->role;
	    $loginLink = $this->loginLink;
	    Mail::send('dispatch.emails.user_notification_mail', ['user_details'=>$user_details,'role'=>$role,'password'=>$password,'loginLink'=>$loginLink], function($message) use ($email,$user_details,$role,$password,$loginLink)
	    {
		    $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
		    $message->to($email,$user_details->name)->subject('Interactive Insurance Brokers LLC - User Added Information');
	    });
    }
}
