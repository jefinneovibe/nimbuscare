<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class QuoteFilledInformationInsurer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user_name;
    protected $user_email;
    protected $customerName;
    protected $temp_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_name, $user_email, $customerName, $temp_path)
    {
        $this->user_name = $user_name;
        $this->user_email = $user_email;
        $this->customerName = $customerName;
        $this->temp_path = $temp_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user_name = $this->user_name;
        $user_email = $this->user_email;
        $customerName = $this->customerName;
        $temp_path = $this->temp_path;
        Mail::send('email_templates.quote_fill_informer_insurer',['email'=>$user_email,'user'=>$user_name,'customerName'=>$customerName], function($message) use ($user_email,$temp_path,$user_name)
        {
            $message->from('info@iibcare.com',' Interactive Insurance Brokers LLC');
            $message->to($user_email,$user_name)->subject("Quote Filled Information");
            $message->attach($temp_path);
        });
    }
}
