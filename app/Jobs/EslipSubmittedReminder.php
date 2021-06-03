<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EslipSubmittedReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $pathToFile;
    protected $user;
    protected $link;
    protected $files;
    protected $comment;
    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $pathToFile, $user, $link, $files, $comment, $type)
    {
        $this->email = $email;
        $this->pathToFile = $pathToFile;
        $this->user = $user;
        $this->link = $link;
        $this->files = $files;
        $this->comment = $comment;
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
        $pathToFile = $this->pathToFile;
        $user = $this->user;
        $link = $this->link;
        $files = $this->files;
        $comment = $this->comment;
        $type = $this->type;
        Mail::send(
            'email_templates.eslip_notification', ['email' => $email, 'user' => $user, 'link' => $link, 'comment' => $comment, 'type' => $type], function ($message) use ($email, $type, $pathToFile, $user, $files) {
                $message->from('info@iibcare.com', ' Interactive Insurance Brokers LLC');
                $message->to($email, $user->name)->subject("Request for Quotation-" . $type);
                $message->attach($pathToFile);
                if ($files!=null) {
                    foreach ($files as $fileName => $file) {
                        $message->attach($file, ['as' => $fileName ]);
                    }
                }
            }
        );
    }
}
