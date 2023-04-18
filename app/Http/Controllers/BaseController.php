<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponder;
use Illuminate\Support\Collection;

/** 
 * 
 * @group Base Controller
 */

class BaseController extends Controller
{
    use ApiResponder;
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        try {
            return $this->success($this->model->all());
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function getPaginatedData(Request $request)
    {
        try {
            return $this->success($this->model->paginate($request->per_page));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            return $this->success($this->model->find($id));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {
            return $this->success($this->model->create($request->all()), 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $this->model->find($id);
            $data->update($request->all());
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->model->find($id);
            $data->delete();
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}