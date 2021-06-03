<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class Sendcasemangerleads implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $casename;
    protected $caseemail;
    protected $referencenumber;
    protected $name;
    protected $caselink;
    protected $customername;
    protected $transferBy;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($casename,$caseemail,$referencenumber,$name,$caselink,$customername,$transferBy)
    {
        $this->casename=$casename;
        $this->caseemail=$caseemail;
        $this->referencenumber=$referencenumber;
        $this->name=$name;
        $this->caselink=$caselink;
        $this->customername=$customername;
        $this->transferBy=$transferBy;

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
	    $transferBy=$this->transferBy;
        $customername=$this->customername;
        $data=['casename'=>$casename,'caseemail'=>$caseemail,'referencenumber'=>$referencenumber,'name'=>$name,'caselink'=>$caselink,'customername'=>$customername,'transferBy'=>$transferBy];
        Mail::send('email_templates.send_casemanagerleads_email', $data, function($message) use ($casename,$caseemail,$referencenumber,$name,$caselink,$customername,$transferBy)
        {
            $message->from(Config::get('app_key.mail_id'), ' Interactive Insurance Brokers LLC');
            $message->to($caseemail)->subject('Interactive Insurance Brokers LLC - Lead Transferred');
        });
    }
}
