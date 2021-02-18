<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;

class ClearDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:clear_db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear DB';

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
    public function handle()
    {
        Task::truncate();

        $this->info('"Task" table is truncated');
    }
}
