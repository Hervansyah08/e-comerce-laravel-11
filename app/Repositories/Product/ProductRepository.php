<?php

namespace App\Repositories\Product;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository
{
    public function getProducts(Request $request);
    public function getCategories();
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function search($query);
}
