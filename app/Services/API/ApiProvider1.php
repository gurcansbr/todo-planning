<?php

namespace App\Services\API;

use Illuminate\Support\Facades\Http;
use App\Models\Task;
use App\Contracts\ApiProvider;
use Illuminate\Support\Collection;

class ApiProvider1 implements ApiProvider {
    private $url = "http://www.mocky.io/v2/5d47f24c330000623fa3ebfa";
    public $name = "Provider1";

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
                'name' => $task['id'],
                'duration' => $task['sure'],
                'level' => $task['zorluk']
            ]);
        }
    }
}