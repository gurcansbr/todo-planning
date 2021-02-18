<?php

namespace App\Services\API;

use Illuminate\Support\Facades\Http;
use App\Models\Task;
use App\Contracts\ApiProvider;
use Illuminate\Support\Collection;

class ApiProvider2 implements ApiProvider {
    private $url = "http://www.mocky.io/v2/5d47f235330000623fa3ebf7";
    public $name = "Provider2";

    /**
     * Getting data from api provider
     * 
     * @return Collection
     */
    public function getDataFromApi() : Collection
    {
        $response = Http::get($this->url);
        $data = $response->json();
        
        return collect($data);
    }

    /**
     * Store data to db
     * 
     * @param $tasks : Collection
     * @return void
     */
    public function storeData($tasks) : void
    {
        if(count($tasks) <= 0) throw new \Exception("There are no avaiable data!");
        if(Task::count() > 0) throw new \Exception("DB already has a data!");

        foreach($tasks as $task){
            Task::create([
                'name' => array_key_first($task),
                'duration' => $task[array_key_first($task)]['estimated_duration'],
                'level' => $task[array_key_first($task)]['level']
            ]);
        }
    }
}