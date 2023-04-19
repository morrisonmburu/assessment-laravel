<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Tasks\UserTaskRequest;
use App\Models\Task;
use App\Models\Status;
use App\Models\UserTask;
use Illuminate\Http\Request;

class UserTasksController extends BaseController
{
    public function __construct(UserTask $model)
    {
        $this->model = $model;
    }

    public function store(UserTaskRequest $request, $id)
    {
        try {
            $task = Task::find($id);
            $userTask = $task->userTasks()->create($request->all());
            return $this->success($userTask, 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(UserTaskRequest $request, $id)
    {
        try {
            $userTask = $this->model->find($id);
            $userTask->update($request->all());
            return $this->success($userTask);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $userTask = $this->model->find($id);
            $userTask->delete();
            return $this->success($userTask);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}