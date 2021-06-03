<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendReception implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $casename;
    protected $caseemail;
    protected $referencenumber;
    protected $name;
    protected $caselink;
    protected $saveMethod;
    protected $leadss;
    protected $customername;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($casename,$caseemail,$referencenumber,$name,$caselink,$saveMethod,$leadss,$customername)
    {
        $this->casename=$casename;
        $this->caseemail=$caseemail;
        $this->referencenumber=$referencenumber;
        $this->name=$name;
        $this->caselink=$caselink;
        $this->saveMethod=$saveMethod;
        $this->leadss=$leadss;
        $this->customername=$customername;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $casename=$this->casename;
        $caseemail=$this->caseemail;
        $referencenumber=$this->referencenumber;
        $name  =$this->name;
        $caselink=$this->caselink;
        $saveMethod=$this->saveMethod;
        $leadss=$this->leadss;
        $customername=$this->customername;
        $data=['casename'=>$casename,'caseemail'=>$caseemail,'referencenumber'=>$referencenumber,'name'=>$name,'caselink'=>$caselink,'saveMethod'=>$saveMethod,'leadss'=>$leadss,'customername'=>$customername];
        Mail::send('email_templates.send_reception_mail', $data, function($message) use ($casename,$caseemail,$referencenumber,$name,$caselink,$saveMethod,$leadss,$customername)
        {
            if($saveMethod =='approve_button'){
                $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
                $message->to($caseemail)->subject('Interactive Insurance Brokers LLC - Lead Approved');
            }elseif($saveMethod =='reject_button'){
                $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
                $message->to($caseemail)->subject('Interactive Insurance Brokers LLC - Lead Rejected');
            }
            elseif($saveMethod =='submitt_button'){
                $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
                $message->to($caseemail)->subject('Interactive Insurance Brokers LLC - Lead Delivered');
            }
        });
    }
}
