<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function create(array $attributes = [])
    {
        $model = parent::create($attributes);
        return $model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        $model = parent::update($attributes, $options);
        return $model;
    }

    public function delete()
    {
        $model = parent::delete();
        return $model;
    }
}