<?php

namespace App\Services\Planning;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class PlanningService {
    /**
     * Developers with their levels
     */
    private $developers = [
        'dev5' => '5',
        'dev4' => '4',
        'dev3' => '3',
        'dev2' => '2',
        'dev1' => '1'
    ];

    private $tasks;
    private $devTotalTimes;
    private $estimatedDuration;
    private $taskCount;
    private $devTasks;

    /**
     * Initialize required data
     */
    public function init($tasks)
    {
        if(count($tasks) <= 0) throw new \Exception("There are no avaiable tasks!");
        
        $this->estimatedDuration = $this->getEstimatedDuration($tasks) / 15;
        $this->taskCount = $tasks->count();

        $this->tasks = collect([
            '5' => $this->getTasksByLevel($tasks, 5, false),
            '4' => $this->getTasksByLevel($tasks, 4, false),
            '3' => $this->getTasksByLevel($tasks, 3, false),
            '2' => $this->getTasksByLevel($tasks, 2, false),
            '1' => $this->getTasksByLevel($tasks, 1, false),
        ]);

        $this->devTotalTimes = collect([
            '5' => 0,
            '4' => 0,
            '3' => 0,
            '2' => 0,
            '1' => 0,
        ]);

        $this->devTasks = collect([
            '5' => collect(),
            '4' => collect(),
            '3' => collect(),
            '2' => collect(),
            '1' => collect(),
        ]);
    }

    /**
     * Calculate best planning for developers
     */
    public function calculate() : void
    {
        foreach($this->developers as $developer){
            $tasks = $this->tasks[$developer];
            $this->calculateRec($tasks, $developer, $developer);
        }

        $checkTasks = $this->tasks->sum(function($item){
            return count($item);
        });
        if($checkTasks != 0){
            $this->calculateRec($this->tasks[$this->findTasks()], $this->findDeveloper());
        }
    }

    /**
     * Recursive calculation
     */
    private function calculateRec($tasks, $dev)
    {
        if($this->devTotalTimes[$dev] > $this->estimatedDuration or $dev < 1){
            return;
        }

        if(count($tasks) == 0) $this->calculateRec($this->tasks[$dev - 1], $dev - 1);

        foreach($tasks as $key => $task){
            $tempTime = ($task['duration'] / $dev);
            $time = $this->devTotalTimes[$dev];
            if($time + $tempTime < $this->estimatedDuration){
                $this->devTotalTimes[$dev] += $tempTime;
                $this->devTasks[$dev]->push($task);
                $this->tasks[$dev]->forget($key);
            } else {
                if($dev <= 1) return;
                $this->calculateRec($this->tasks[$dev - 1]->sortByDesc('duration'), $dev - 1);
            }
        }
    }

    /**
     * Return planning results
     */
    public function getResults() : Collection
    {
        return collect([
            'devTasks' => $this->devTasks,
            'devTotalTimes' => $this->devTotalTimes
        ]);
    }

    /**
     * Get tasks by task level
     */
    private function getTasksByLevel($tasks, $level, $desc)
    {
        return $tasks->where('level', $level)->sortBy('duration', $desc)->values();
    }

    private function getEstimatedDuration($tasks)
    {
        $totalDuration = 0;
        
        $totalDuration += $tasks->where('level', 5)->sum('duration');
        $totalDuration += $tasks->where('level', 4)->sum('duration');
        $totalDuration += $tasks->where('level', 3)->sum('duration');
        $totalDuration += $tasks->where('level', 2)->sum('duration');
        $totalDuration += $tasks->where('level', 1)->sum('duration');

        return $totalDuration;
    }

    /**
     * Find developer which has min total time
     */
    private function findDeveloper()
    {
        $times = array_values($this->devTotalTimes->toArray());
        return array_search(min($times), $this->devTotalTimes->toArray());
    }

    /**
     * Find tasks which has max count tasks
     */
    private function findTasks()
    {
        $temp = collect();
        foreach($this->tasks as $key => $task){
            $temp->push([
                'id' => $key,
                'count' => count($task)
            ]);
        }

        return $temp->sortByDesc('count')->first()['id']; 
    }
}