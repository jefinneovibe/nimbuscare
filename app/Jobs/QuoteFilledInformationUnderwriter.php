<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class QuoteFilledInformationUnderwriter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $name;
    protected $email;
    protected $insurerName;
    protected $customerName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $email, $insurerName, $customerName)
    {
        $this->name = $name;
        $this->email = $email;
        $this->insurerName = $insurerName;
        $this->customerName = $customerName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->name;
        $email = $this->email;
        $insurerName = $this->insurerName;
        $customerName = $this->customerName;
        Mail::send('email_templates.quote_fill_informer',['name'=>$name,'insurerName'=>$insurerName, 'customerName'=>$customerName], function($message) use ($email,$name)
        {
            $message->from('info@iibcare.com',' Interactive Insurance Brokers LLC');
            $message->to($email,$name)->subject('Insurer Quote Filled Information');
        });
    }
}
