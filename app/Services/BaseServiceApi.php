<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseServiceApi
{
    public function findAll(?array $fields, ?int $perPage, ?string $orderBy = null) : \Illuminate\Contracts\Pagination\LengthAwarePaginator | Collection;
    public function store(array $data) : Model;
    public function show(int $id) : Model|null;
    public function update(int $id, array $data) : bool|int|Model;
    public function delete(int $id) : bool|int;
}
