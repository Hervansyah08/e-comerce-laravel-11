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

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ], [
                'email.required' => 'Email is required',
                'email.email' => 'Please enter a valid email address',
                'password.required' => 'Password is required',
            ]);

            // $request->boolean('remember') ini buat fitur remember, jadi ketika di centang fitur nya mengirim true
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();

                $user = Auth::user();
                $redirectTo = $user->hasRole('admin') ? route('admin.dashboard') : route('home');

                // Fungsi ini akan mengarahkan pengguna ke halaman yang sebelumnya mereka coba akses sebelum login, kayak sebelumnya berada di route dasboard
                // Jika tidak ada halaman sebelumnya, pengguna diarahkan ke redirectTo
                return redirect()->intended($redirectTo)
                    ->with('success', 'Welcome back, ' . $user->name . '!'); // memberikan pesan
            }

            // untuk memberikan pesan error khusus di bagian field email ketika proses autentikasi gagal.
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($request->except('password'));
        } catch (Exception $e) {
            Log::error('Error during login: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An unexpected error occurred. Please try again.')
                ->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('home')
                ->with('success', 'You have been logged out successfully');
        } catch (Exception $e) {
            Log::error('Error during logout: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to logout. Please try again.');
        }
    }
}
