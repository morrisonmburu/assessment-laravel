<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\BaseController;
use App\Models\Task;
use App\Models\Status;
use Illuminate\Http\Request;

class TasksController extends BaseController
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        try {
            return $this->success($this->model->with('status')->get());
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $task = $this->model->fill($request->all());
            $task->status()->associate(Status::where('name', 'New')->first());
            $task->save();
            return $this->success($task, 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(Request $request ,$id)
    {
        try {
            $task = $this->model->find($id);
            $task->update($request->all());
            return $this->success($task);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}