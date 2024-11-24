<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index(Request $request)
    {
        try {
            $categories = $this->categoryRepository->getAll($request);
            return view('admin.category', compact('categories'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load categories: ' . $e->getMessage());
        }
    }
}
