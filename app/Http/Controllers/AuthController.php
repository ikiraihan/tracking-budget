<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

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
            // Validate both User and Supir fields
            $request->validate([
                // User fields
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:50|unique:users,username',
                'password' => 'required|string|min:6|confirmed',
                // Supir fields
                'truk_id' => 'nullable|exists:truk,id',
                'telepon' => 'nullable|string|max:50',
                'alamat' => 'nullable|string|max:255',
                'no_ktp' => 'nullable|string|max:100',
                'no_sim' => 'nullable|string|max:100',
                'photo_diri' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'photo_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'photo_sim' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            ]);
    
            // Create User
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'is_active' => 0,
            ]);
    
            // Create Supir
            $supir = new Supir();
            $supir->truk_id = $request->truk_id;
            $supir->user_id = $user->id;
            $supir->nama = $request->name;
            $supir->telepon = $request->telepon;
            $supir->alamat = $request->alamat;
            $supir->no_ktp = $request->no_ktp;
            $supir->no_sim = $request->no_sim;
    
            if ($request->hasFile('photo_diri') && $request->file('photo_diri')->isValid()) {
                $file = $request->file('photo_diri');
                $filename = time() . '_diri_' . $file->getClientOriginalName();
                $destination = public_path('uploads/supir/diri');
                if (!file_exists($destination)) mkdir($destination, 0755, true);
                $file->move($destination, $filename);
                $supir->path_photo_diri = '/uploads/supir/diri/' . $filename;
            }
    
            if ($request->hasFile('photo_ktp') && $request->file('photo_ktp')->isValid()) {
                $file = $request->file('photo_ktp');
                $filename = time() . '_ktp_' . $file->getClientOriginalName();
                $destination = public_path('uploads/supir/ktp');
                if (!file_exists($destination)) mkdir($destination, 0755, true);
                $file->move($destination, $filename);
                $supir->path_photo_ktp = '/uploads/supir/ktp/' . $filename;
            }
    
            if ($request->hasFile('photo_sim') && $request->file('photo_sim')->isValid()) {
                $file = $request->file('photo_sim');
                $filename = time() . '_sim_' . $file->getClientOriginalName();
                $destination = public_path('uploads/supir/sim');
                if (!file_exists($destination)) mkdir($destination, 0755, true);
                $file->move($destination, $filename);
                $supir->path_photo_sim = '/uploads/supir/sim/' . $filename;
            }
    
            $supir->save();
    
            return redirect()->route('login')->with('success', 'Registrasi berhasil. Silahkan Hubungi Admin untuk Verifikasi Akun!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with(['error' => 'Terjadi kesalahan saat registrasi. Pesan Kesalahan: ' . $e->getMessage()]);
        }
    }
    

    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $user = User::where('username', $request->username)->first();

            if ($user && $user->is_active == 0) {
                throw new Exception('Akun Anda belum diverifikasi. Silakan hubungi admin.');
            }

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw new Exception('Username atau password salah.');
            }

            Auth::login($user);

            return redirect('/dashboard');
        } catch (\Exception $e) {
            return back()->withInput()
            ->with(['error' => $e->getMessage()]);
            // ->withErrors([
            //     'username' => $e->getMessage(),
            // ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}