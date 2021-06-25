<?php

namespace App\Repositories;

use App\TodoList;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\TodoListContract;

class TodoListRepository extends BaseRepository implements TodoListContract
{
    protected $model;

    public function __construct(TodoList $model)
    {
        $this->model = $model;
    }
}