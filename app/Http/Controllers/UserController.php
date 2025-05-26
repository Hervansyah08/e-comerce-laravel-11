<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        try {
            $users = $this->user->getAll($request);
            return view('admin.user', compact('users'));
        } catch (Exception $e) {
            Log::error("Kesalahan di controller" . $e->getMessage());
            return back()->with('error', 'Failed to load categories: ' . $e->getMessage());
        }
    }
}
