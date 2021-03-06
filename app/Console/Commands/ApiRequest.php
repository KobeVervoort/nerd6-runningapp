<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\StravaHandler;

class ApiRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        \Log::info('Fetched user activities at ' . Carbon::now());
        // API request for all the activities
        StravaHandler::handleApiRequestAllActivities();

        \Log::info('Calculating user distances at ' . Carbon::now());
        // Calculation on table activities
        StravaHandler::userDistances();

    }
}
