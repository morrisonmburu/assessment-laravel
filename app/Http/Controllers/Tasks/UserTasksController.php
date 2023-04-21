<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\BaseController;
use App\Models\Task;
use App\Models\Status;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTasksController extends BaseController
{
    public function __construct(UserTask $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        try {
            $userTasks = $this->model->with('status', 'task')->where('user_id', Auth::user()->id)->get();
            // get tasks from userTasks
            $tasks = $userTasks->map(function ($userTask) {
                $task = $userTask->task;
                $task->status = $userTask->status;
                $task->user_task_id = $userTask->id;
                return $task;
            });
            return $this->success($tasks);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $userTask = $this->model->with('status', 'task')->find($id);
            $userTask->task->status = $userTask->status;
            $userTask->task->user_task_id = $userTask->id;
            return $this->success($userTask->task);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {
            array_map(function ($user) use (&$request) {
                $task = Task::find($request->id);
                $task->userTask()->create([
                    'user_id' => $user['id'],
                    'status_id' => $request->status_id,
                    'task_id' => $request->id,
                    'due_date' => $request->due_date,
                    'remarks' => $request->remarks ?? '',
                ]);
            }, $request->users);
            return $this->success($request->all(), 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $userTask = $this->model->find($request->user_task_id);
            $userTask->status_id = $request->status;
            $userTask->save();
            return $this->success($userTask);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}