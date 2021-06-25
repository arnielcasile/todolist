<?php

namespace App\Services;

use App\Services\Contracts\TodoListContract;
use App\Repositories\Contracts\TodoListContract as TodoListRepositoryContract;

class TodoListService implements TodoListContract
{
    protected $todoListRepoContract;

    public function __construct(TodoListRepositoryContract $todoListRepoContract)
    {
        $this->todoListRepoContract = $todoListRepoContract;
    }

    public function loadAll()
    {
        return $this->todoListRepoContract->loadAll();
    }

    public function create($data)
    {
        return $this->todoListRepoContract->create($data);
    }

    public function find($id)
    {
        return $this->todoListRepoContract->find($id);
    }

    public function update($id, $data)
    {
        return $this->todoListRepoContract->update($id, $data);
    }

    public function deleted($id)
    {
        return $this->todoListRepoContract->delete($id);
    }


}