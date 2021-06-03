<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class reminderRenewalMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $name;
    protected $mailSubject;
    protected $mailID;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailID, $name, $mailSubject)
    {
        $this->name = $name;
        $this->mailSubject = $mailSubject;
        $this->mailID = $mailID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name=$this->name;
        $mailSubject=$this->mailSubject;
        $mailID=$this->mailID;
        Mail::send('enquiry_management.renewal_mail', ['name'=>$name,'mailSubject'=>$mailSubject,'mailID'=>$mailID], function ($message) use ($name, $mailID) {
            $message->from('info@iibcare.com', ' Interactive Insurance Brokers LLC');
            $message->to($mailID, $name)->subject('Interactive Insurance Brokers LLC-Reminder');
        });
    }
}
