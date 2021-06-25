<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseContract;

abstract class BaseRepository implements BaseContract
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function loadAll()
    {
        return $this->model->all();   
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {

        return $this->model->findOrFail($id);  
    }

    public function update($id, array $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete()
                ? true : false;
    }
}