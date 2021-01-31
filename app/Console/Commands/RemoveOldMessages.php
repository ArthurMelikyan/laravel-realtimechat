<?php

namespace App\Console\Commands;

use App\Chat;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveOldMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '24 hours old messages removed';

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
     * @return int
     */
    public function handle(){
        // \Log::debug('test');
        Chat::where('created_at', '<', Carbon::parse('-24 hours'))->delete();
        $this->info('24 hours old messages removed');
        return 1;
    }
}
