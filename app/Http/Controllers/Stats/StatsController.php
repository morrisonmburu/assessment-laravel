<?php

namespace App\Http\Controllers\Stats;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Status;
use App\Models\UserTask;
use App\Http\Helpers\ApiResponder;

class StatsController extends Controller
{
    use ApiResponder;
    public function index()
    {
        try {
            $stats = [
                'tasks' => Task::count(),
                'assignedtasks' => UserTask::count(),
            ];

            $mytasks = UserTask::where('user_id', Auth::user()->id)->get();
            $allTasks = Task::all();

            $myStatusStats = [];
            $statuses = Status::all();
            foreach ($statuses as $status) {
                $myStatusStats[$status->name] = $mytasks->where('status_id', $status->id)->count();
            }

            $stats['mystatus'] = $myStatusStats;

            $allStatusStats = [];
            foreach ($statuses as $status) {
                $allStatusStats[$status->name] = $allTasks->where('status_id', $status->id)->count();
            }

            $stats['allstatus'] = $allStatusStats;

            return $this->success($stats);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }   
    }
}