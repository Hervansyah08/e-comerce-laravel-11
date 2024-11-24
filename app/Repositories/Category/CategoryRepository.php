<?php

namespace App\Repositories\Category;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface CategoryRepository extends Repository
{
    public function getAll(Request $request);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
}
