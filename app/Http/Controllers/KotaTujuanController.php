<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KotaTujuanController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username', 
                'role_id' => 'required|exists:roles,id',
                'is_active' => 'nullable|boolean',
                'password' => 'required|string|min:6|confirmed',
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'is_active' => 1,
            ]);

            return redirect()->route('user.index')->with('success', 'Data User berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data truk: ' . $e->getMessage())->withInput();
        }
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user->id, 
                'role_id' => 'required|exists:roles,id',
                'is_active' => 'nullable|boolean',
            ]);

            $user->name = $request->name;
            $user->username = $request->username;
            $user->role_id = $request->role_id;
            $user->is_active = $request->is_active;
    
            $user->save();
    
            return redirect()->route('user.index')->with('success', 'Data User berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data user.');
        }
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            return redirect()->route('user.index')->with('success', 'Data user berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data user: ' . $e->getMessage());
        }
    } 
    
    public function changePassForm($id)
    {
        $user = User::find($id);

        return view('user.change', compact('user'));
    }

    public function changePass(Request $request, $id)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::findOrFail($id);
            $user->password = Hash::make($request->password);

            $user->save();

            return redirect('/user')->with('success', 'Password Berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => 'Terjadi kesalahan saat memperbarui data. Pesan: ' . $e->getMessage()]);
        }
    }
}