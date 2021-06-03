<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\EnquiryManagementController;

class RenewalReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:renewal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job for renewal(Enquiry managemnt)';

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
        EnquiryManagementController::renewalReminder();
    }
}
