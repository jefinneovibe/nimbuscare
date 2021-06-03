<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Emails;

class ForwardMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries=3;
    public $timeout=120;
    protected $mailId;
    protected $forwardTo;
    protected $cc;
    protected $body;
    public function __construct($mailId, $forwardTo, $cc, $body)
    {
        $this->mailId=$mailId;
        $this->forwardTo=$forwardTo;
        $this->cc=$cc;
        $this->body=$body;
    }

    /**
     * Execute the job.
     * Job to forward the mail
     * @return void
     */
    public function handle()
    {
        $mailId=$this->mailId;
        $forwardTo=$this->forwardTo;
        $cc=$this->cc;
        $body=$this->body;
        $mails=Emails::find($mailId);
        $mail=$mails->mailsContent;
        $subject=$mails->subject;
        if ($mails->isAttach==1) {
            $attachments=$mails->attachements;
        } else {
            $attachments="";
        }
        $data=['mail'=>$mail,'forwardTo'=>$forwardTo,'body'=>$body];
        Mail::send(
            'document_management.forward_document',
            $data,
            function ($message) use ($forwardTo, $attachments, $cc, $subject) {
                $message->from('info@iibcare.com', 'Interactive Insurance Brokers LLC');
                $message->to($forwardTo, '');
                $message->subject($subject);
                if ($cc) {
                    $message->cc($cc);
                }
                if (isset($attachments) && $attachments!="") {
                    foreach ($attachments as $attachment) {
                        $attachmentPath=$attachment['attachPath'];
                        $message->attach($attachmentPath);
                    }
                }
            }
        );
    }
}
