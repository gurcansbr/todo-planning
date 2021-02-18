<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Planning\PlanningService;
use App\Models\Task;

class HomeController extends Controller
{
    private $planning;

    public function __construct(PlanningService $planning)
    {
        $this->planning = $planning;
    }

    public function index()
    {
        return view('index');
    }

    public function results()
    {
        $tasks = Task::all();
        $this->planning->init($tasks);
        $this->planning->calculate();
        $results = $this->planning->getResults();

        $completedCount = 0;
        foreach($results['devTasks'] as $devTask){
            $completedCount += count($devTask);
        }

        $completedTime = number_format(max(array_values($results['devTotalTimes']->toArray())) / 45, 2);
        
        return view('result')->with('results', [
            'task_count' => count($tasks),
            'completed_task_count' => $completedCount,
            'completed_time' => $completedTime,
            'devTasks' => $results['devTasks'],
            'devTotalTimes' => $results['devTotalTimes']
        ]);
    }
}
