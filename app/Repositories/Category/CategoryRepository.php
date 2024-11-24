<?php

namespace App\Repositories\Category;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface CategoryRepository extends Repository
{
    public function getAll(Request $request);
    public function create($data);
    public function update($category, $data);
    public function delete($category);
}
