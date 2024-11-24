<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to load categories: ' . $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable'
        ], [
            'name.required' => 'Nama Kategori Wajib di isi',
        ]);
        try {
            $this->categoryRepository->create($data);
            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal Menambahkan Kategori: ' . $e->getMessage())
                ->withInput();
        }
    }
}
