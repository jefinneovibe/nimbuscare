<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendAssignleads implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $assignname;
    protected $assignemail;
    protected $referencenumber;
    protected $name;
    protected $caselink;
    protected $saveMethod;
    protected $action;
    protected $customername;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($assignname,$assignemail,$referencenumber,$name,$caselink,$saveMethod,$action,$customername)
    {
        $this->assignname=$assignname;
        $this->assignemail=$assignemail;
        $this->referencenumber=$referencenumber;
        $this->name=$name;
        $this->caselink=$caselink;
        $this->saveMethod=$saveMethod;
        $this->action=$action;
        $this->customername=$customername;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $assignname=$this->assignname;
        $assignemail=$this->assignemail;
        $referencenumber=$this->referencenumber;
        $name  =$this->name;
        $caselink=$this->caselink;
        $saveMethod=$this->saveMethod;
        $action=$this->action;
        $customername=$this->customername;
        $data=['assignname'=>$assignname,'assignemail'=>$assignemail,'referencenumber'=>$referencenumber,'name'=>$name,'caselink'=>$caselink,'saveMethod'=>$saveMethod,'action'=>$action,'customername'=>$customername];
        Mail::send('dispatch.emails.lead_email_assign', $data, function($message) use ($assignname,$assignemail,$referencenumber,$name,$caselink,$saveMethod,$action,$customername)
        {
                $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
                $message->to($assignemail,$assignname)->subject('Interactive Insurance Brokers LLC - Lead Assigned');
        });
    }
}
