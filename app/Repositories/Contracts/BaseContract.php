<?php

namespace App\Repositories\Contracts;

interface BaseContract
{
    public function loadAll();

    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);
}