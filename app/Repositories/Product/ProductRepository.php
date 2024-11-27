<?php

namespace App\Repositories\Product;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository
{
    public function getProducts(Request $request);
    public function getCategories();
}
