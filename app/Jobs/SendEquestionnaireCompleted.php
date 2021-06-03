<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendEquestionnaireCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $name;
    protected $email;
    protected $refNumber;
    protected $type;
    public function __construct($email, $name, $refNumber,$type)
    {
        $this->name = $name;
        $this->email = $email;
        $this->refNumber = $refNumber;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->email;
        $name = $this->name;
        $refNumber = $this->refNumber;
	    $type = $this->type;
        $data = ['name'=>$name, 'refNumber'=>$refNumber,'type'=>$type];
        Mail::send('email_templates.send_questionnaire_complete', $data, function($message) use ($email,$name,$type)
        {
            $message->from('info@iibcare.com',' Interactive Insurance Brokers LLC');
            $message->to($email,$name)->subject("Confirmation- E-questionnaire Completed for ".$type);
        });
    }
}
