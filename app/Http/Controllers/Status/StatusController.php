<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\BaseController;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends BaseController
{
    public function __construct(Status $model)
    {
        $this->model = $model;
    }
}