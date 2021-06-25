<?php

namespace App\Services\Contracts;

interface TodoListContract
{

    public function loadAll();

    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function deleted($id);
}