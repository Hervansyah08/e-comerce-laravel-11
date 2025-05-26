<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class UserService
{
    // protected User $model;

    // public function __construct(User $user)
    // {
    //     $this->model = $user;
    // }

    public function getAll(Request $request)
    {
        try {
            return User::query() // query ini sebuah kuas yang akan kamu gunakan untuk "melukis" sebuah permintaan (query) ke database.
                ->role('user')
                // when ini untuk kondisi yang lebih kompleks
                // $request->filled('search') Mengecek apakah parameter search di request memiliki nilai
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = $request->search; // untuk mengambil nilai dari input pengguna (dikirim melalui HTTP request) dengan nama parameter search
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(5)
                ->withQueryString(); // Ini penting untuk mempertahankan parameter search saat paginasi
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data user:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil semua data user");
        }
    }
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'password' => Hash::make($data['password']),
            ]);
            $user->assignRole('user');
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::warning("Gagal menambahkan Akun User :" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat menambahkan Akun user ");
        }
    }
}
