<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
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
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'Email already registered',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
        ]);
        try {
            $this->user->create($validated);
            return redirect()->route('admin.user.index')->with('success', 'User berhasil dibuat');
        } catch (Exception $e) {
            Log::error("Kesalahan di controller" . $e->getMessage());
            return back()->with('error', 'Gagal Menambahkan Akun: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            $this->user->delete($user->id);

            return redirect()->route('admin.user.index')->with('success', 'Akun User berhasil dihapus');
        } catch (Exception $e) {
            Log::error("Kesalahan saat menghapus user ID {$user->id}: " . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
}
