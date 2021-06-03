<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendCustomer implements ShouldQueue
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
    protected $prefered_date;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($custname,$custemail,$referencenumber,$name,$caselink,$saveMethod,$action,$leadss, $prefered_date)
    {
        $this->custname=$custname;
        $this->custemail=$custemail;
        $this->referencenumber=$referencenumber;
        $this->name=$name;
        $this->caselink=$caselink;
        $this->saveMethod=$saveMethod;
        $this->action=$action;
        $this->leadss=$leadss;
        $this->prefered_date = $prefered_date;

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
        $prefered_date = $this->prefered_date;

        $data=['custname'=>$custname,'custemail'=>$custemail,'referencenumber'=>$referencenumber,'name'=>$name,'caselink'=>$caselink,
            'saveMethod'=>$saveMethod,'action'=>$action,'leadss'=>$leadss, 'prefered_date'=> $prefered_date];
        Mail::send('dispatch.emails.leads_email_customer', $data, function($message) use ($custname,$custemail,$referencenumber,$name,$caselink,$saveMethod,$action,$leadss)
        {
            $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
            $message->to($custemail)->subject('Interactive Insurance Brokers LLC - Lead Delivered');
        });
    }
}
