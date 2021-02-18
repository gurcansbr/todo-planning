<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\ApiProvider;

class GetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:get_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from API';

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
    public function handle(ApiProvider $provider)
    {
        try{
            $tasks = $provider->getDataFromApi();
            $provider->storeData($tasks);

            $this->info('Data was successfully retrieved from API. Provider: ' . $provider->name);
        } catch (\Exception $e){
            $this->error('Something went wrong! Exception Message: ' . $e->getMessage());
        }
    }
}
