<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Tasks\TasksRequest;
use App\Models\Task;
use App\Models\Status;
use Illuminate\Http\Request;

class TasksController extends BaseController
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }
}