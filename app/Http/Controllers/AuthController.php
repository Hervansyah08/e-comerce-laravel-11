<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        try {
            // bisa pakai validasi terpisah
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

            DB::beginTransaction(); // Memulai transaksi
            try {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'password' => bcrypt($validated['password']),
                ]);
                $user->assignRole('user');

                // memicu event Registered setelah pengguna berhasil dibuat. kayak verifikasi email
                event(new Registered($user));

                // untuk langsung login pengguna setelah pendaftaran berhasil.
                Auth::login($user);

                DB::commit();

                return redirect()->route('home')
                    ->with('success', 'Account created successfully! Welcome ' . $user->name);
            } catch (QueryException $e) { //subclass dari Exception yang spesifik untuk kesalahan database.
                DB::rollBack(); // Membatalkan semua perubahan yang sudah dilakukan di database.
                Log::error('Database error during registration: ' . $e->getMessage()); // Mencatat error ke file log.
                return redirect()->back()
                    ->with('error', 'Failed to create account. Please try again.') // Memberikan pesan error kepada user.
                    ->withInput($request->except('password', 'password_confirmation')); // Mengembalikan input, kecuali password.
            }
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($request->except('password', 'password_confirmation')); // Mengembalikan input, kecuali password.
        } catch (Exception $e) {
            Log::error('Error during registration: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An unexpected error occurred. Please try again.')
                ->withInput($request->except('password', 'password_confirmation')); // Mengembalikan input, kecuali password.
        }
    }
}
