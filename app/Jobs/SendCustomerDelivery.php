<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendCustomerDelivery implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $custname;
    protected $custemail;
    protected $referencenumber;
    protected $name;
    protected $caselink;
    protected $saveMethod;
    protected $action;
    protected $leadss;
    protected $documents;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($custname,$custemail,$referencenumber,$name,$caselink,$saveMethod,$action,$leadss, $documents)
    {
        $this->custname=$custname;
        $this->custemail=$custemail;
        $this->referencenumber=$referencenumber;
        $this->name=$name;
        $this->caselink=$caselink;
        $this->saveMethod=$saveMethod;
        $this->action=$action;
        $this->leadss=$leadss;
        $this->documents = $documents;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $custname=$this->custname;
        $custemail=$this->custemail;
        $referencenumber=$this->referencenumber;
        $name  =$this->name;
        $caselink=$this->caselink;
        $saveMethod=$this->saveMethod;
        $action=$this->action;
        $leadss=$this->leadss;
        $documents = $this->documents;
        $data=['custname'=>$custname,'custemail'=>$custemail,'referencenumber'=>$referencenumber,'name'=>$name,'caselink'=>$caselink,'saveMethod'=>$saveMethod,'action'=>$action,'leadss'=>$leadss, 'documents'=> $documents];
        Mail::send('dispatch.emails.leads_email_customer', $data, function($message) use ($custname,$custemail,$referencenumber,$name,$caselink,$saveMethod,$action,$leadss)
        {
	        if($saveMethod =='reject_button'){
		        $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
		        $message->to($custemail)->subject('Interactive Insurance Brokers LLC - Lead Rejected');
           }
	       elseif($saveMethod =='submitt_button'){
		        $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
		        $message->to($custemail)->subject('Interactive Insurance Brokers LLC - Lead Delivered');
	        }
        });
    }
}
