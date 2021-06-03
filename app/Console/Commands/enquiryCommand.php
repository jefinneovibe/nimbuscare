<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\EnquiryManagementController;

class enquiryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enquiry:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh enquiry cron job';

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
        EnquiryManagementController::refreshEnquiry();
    }
}
