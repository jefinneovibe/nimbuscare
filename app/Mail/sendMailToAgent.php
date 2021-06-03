<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;


class sendMailToAgent extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;
	public $agentName;
	public $agentMailID;
	public $referencenumber;
	public $name;
	public $caselink;
	public $saveMethod;
	public $action;
	public $leadss;
	public $custname;
	public $documents;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($agentMailID,$referencenumber,$name,$saveMethod,$action,$leadss,$custname,$documents)
    {
      $this->agentMailID=$agentMailID;
      $this->referencenumber=$referencenumber;
      $this->name=$name;
      $this->saveMethod=$saveMethod;
      $this->action=$action;
      $this->leadss=$leadss;
      $this->custname=$custname;
      $this->documents=$documents;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    $subject='';
	    $saveMethod=$this->saveMethod;
    	if($saveMethod=='reject_button')
	    {
	    	$subject="Lead Rejected";
	    }else if($saveMethod=='submitt_button')
	    {
		    $subject="Lead Delivered";
		
	    }
	    return $this->subject('Interactive Insurance Brokers LLC-'.$subject)
		   ->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC')
		    ->view('dispatch.emails.agentMail');
    }
}
