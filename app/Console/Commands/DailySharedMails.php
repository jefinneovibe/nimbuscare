<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DocumenetManagementController;

class DailySharedMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'the acknowledgement of documents has shared with customer is send through e mails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        DocumenetManagementController::sendCollectedMails();
    }
}
