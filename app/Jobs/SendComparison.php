<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendComparison implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $name;
    protected $email;
    protected $cc_email;
    protected $link;
    protected $workType;
    protected $refNo;
    protected $data;
    protected $comment;
    public function __construct($email, $name, $link, $workType, $refNo, $files, $comment, $cc_email)
    {
        $this->name = $name;
        $this->email = $email;
        $this->cc_email = @$cc_email;
        $this->link = $link;
        $this->workType = $workType;
        $this->refNo = $refNo;
        $this->data = $files;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->email;
        $cc_email = $this->cc_email;
        $name = $this->name;
        $link = $this->link;
        $workType = $this->workType;
        $refNo = $this->refNo;
        $data_file = $this->data;
        $comment = $this->comment;
        $data = ['name'=>$name, 'link'=>$link, 'workType'=>$workType, 'refNo'=>$refNo, 'comment'=>$comment];
        Mail::send(
            'email_templates.send_comparison', $data, function ($message) use ($email,$name,$data_file,$workType, $cc_email) {
                $message->from('info@iibcare.com', ' Interactive Insurance Brokers LLC');
                $message->subject('Interactive Insurance Brokers LLC - E-comparison for ' .$workType.' Policy');
                if (!empty($cc_email)) {
                    foreach ($cc_email as $key => $value) {
                        $message->cc($value);
                    }
                }
                $message->to($email, $name);
                if ($data_file!=null) {
                    foreach ($data_file as $fileName => $file) {
                        $message->attach($file, ['as' => $fileName ]);
                    }
                }
            }
        );
    }
}
