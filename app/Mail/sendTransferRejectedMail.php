<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class sendTransferRejectedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
	public $referencenumber;
	public $name;
	public $saveMethod;
	public $action;
	public $custname;
	public $caselink;
	public $ActionPerformed;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($referencenumber,$name,$saveMethod,$action,$custname,$caselink,$ActionPerformed)
    {
	    $this->referencenumber=$referencenumber;
	    $this->name=$name;
	    $this->saveMethod=$saveMethod;
	    $this->action=$action;
	    $this->custname=$custname;
	    $this->caselink=$caselink;
	    $this->ActionPerformed=$ActionPerformed;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$ActionPerformed=$this->ActionPerformed;
    	if($ActionPerformed=='approved')
	    {
	    	$subject='Interactive Insurance Brokers LLC-Transfer Accepted';
	    }
	    else if($ActionPerformed=='rejected')
	    {
	    	$subject='Interactive Insurance Brokers LLC-Transfer Rejected';
	    }
	    return $this->subject($subject)
		    ->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC')
		    ->view('dispatch.emails.rejectMail');
    }
}
