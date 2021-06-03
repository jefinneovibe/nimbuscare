<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiController;
use Illuminate\Console\Command;

class liveLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push-notification:push-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'push notification for live location';

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
	    ApiController::sendPushNotification();
    }
}
