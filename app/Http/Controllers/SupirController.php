<?php

namespace App\Http\Controllers;

use App\Models\Perjalanan;
use App\Models\Supir;
use App\Models\Truk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupirController extends Controller
{
    public function index()
    {
        $supirsActive = Supir::orderBy('created_at', 'desc')->where('is_active',true)->get();
        $supirsInactive = Supir::orderBy('created_at', 'desc')->where('is_active',false)->get();

        $supirs = collect($supirsActive)->map(function ($supir) {
            return (object) [
                'id' => $supir->id,
                'truk_id' => $supir->truk_id,
                'truk_nama' => $supir->truk->nama ?? null,
                'truk_no_polisi' => $supir->truk->no_polisi ?? null,
                'user_id' => $supir->user_id,
                'name' => $supir->user->name ?? null,
                'telepon' => $supir->telepon,
                'alamat' => $supir->alamat,
                'no_ktp' => $supir->no_ktp,
                'no_sim' => $supir->no_sim,
                'path_photo_diri' => $supir->path_photo_diri,
                'path_photo_ktp' => $supir->path_photo_ktp,
                'path_photo_sim' => $supir->path_photo_sim,
                'is_active' => $supir->is_active,
                'is_verifikasi' => $supir->user_id && $supir->user->is_active == 1 ? true : false,
            ];
        });

        $supirsInactive = collect($supirsInactive)->map(function ($supir) {
            return (object) [
                'id' => $supir->id,
                'truk_id' => $supir->truk_id,
                'truk_nama' => $supir->truk->nama ?? null,
                'truk_no_polisi' => $supir->truk->no_polisi ?? null,
                'user_id' => $supir->user_id,
                'name' => $supir->user->name ?? null,
                'telepon' => $supir->telepon,
                'alamat' => $supir->alamat,
                'no_ktp' => $supir->no_ktp,
                'no_sim' => $supir->no_sim,
                'path_photo_diri' => $supir->path_photo_diri,
                'path_photo_ktp' => $supir->path_photo_ktp,
                'path_photo_sim' => $supir->path_photo_sim,
                'is_active' => $supir->is_active,
                'is_verifikasi' => $supir->user_id && $supir->user->is_active == 1 ? true : false,
            ];
        });

        // dd($supirs);

        return view('supir.index', compact('supirs','supirsInactive'));
    }

    public function detail($id,Request $request)
    {
        $supir = Supir::findOrFail($id);
        $perjalanans = Perjalanan::where('supir_id',$id)->get();
        
        $perjalananRemap = $perjalanans->map(function ($perjalanan) {
            return (object)[
                'id'              => $perjalanan->id,
                'truk_id'         => $perjalanan->truk_id,
                'truk_nopol'      => $perjalanan->truk && $perjalanan->truk->no_polisi ? $perjalanan->truk->no_polisi : null,
                'supir_id'        => $perjalanan->supir_id,
                'supir_nama'      => $perjalanan->supir && $perjalanan->supir->nama ? $perjalanan->supir->nama : null,
                'depart_provinsi_id'   => $perjalanan->depart_provinsi_id,
                'depart_provinsi_nama' => $perjalanan->departProvinsi && $perjalanan->departProvinsi->nama ? $perjalanan->departProvinsi->nama : null,
                'depart_kota_id'   => $perjalanan->depart_kota_id,
                'depart_kota_nama' => $perjalanan->departKota && $perjalanan->departKota->nama ? $perjalanan->departKota->nama : null,
                'return_provinsi_id'   => $perjalanan->return_provinsi_id,
                'return_provinsi_nama' => $perjalanan->returnProvinsi && $perjalanan->returnProvinsi->nama ? $perjalanan->returnProvinsi->nama : null,
                'return_kota_id'   => $perjalanan->return_kota_id,
                'return_kota_nama' => $perjalanan->returnKota && $perjalanan->returnKota->nama ? $perjalanan->returnKota->nama : null,
                'tanggal_berangkat'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat): null,
                'tanggal_berangkat_format'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat)->translatedFormat('d M Y'): null,
                'tanggal_kembali'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali): null,
                'tanggal_kembali_format'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali)->translatedFormat('d M Y'): null,

                'budget'           => $perjalanan->budget ? $perjalanan->budget : null,
                'income'           => $perjalanan->income ? $perjalanan->income : null,
                'expenditure'      => $perjalanan->expenditure ? $perjalanan->expenditure : null,

                'total'            => $perjalanan->budget + $perjalanan->income - $perjalanan->expenditure,
                
                'is_done'      => $perjalanan->is_done ? $perjalanan->is_done : null,
            ];
        });

        return view('supir.detail', [
            'supir' => $supir,
            'perjalanans' => $perjalananRemap,
        ]);
    }

    public function edit($id)
    {
        $supir = Supir::findOrFail($id);
        $truks = Truk::get();
        $user = User::find($supir->user_id);

        return view('supir.edit', compact('supir','truks', 'user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'telepon' => 'required|string|max:50',
                'alamat' => 'required|string|max:255',
                'no_ktp' => 'nullable|string|max:100',
                'no_sim' => 'nullable|string|max:100',
                'truk_id' => 'required|exists:truk,id',
                'photo_diri' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'photo_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'photo_sim' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'is_active' => 'nullable|boolean',
            ]);

            $supir = Supir::findOrFail($id);
            $supir->nama = $request->nama;
            $supir->telepon = $request->telepon;
            $supir->alamat = $request->alamat;
            $supir->no_ktp = $request->no_ktp;
            $supir->no_sim = $request->no_sim;
            $supir->truk_id = $request->truk_id;
            $supir->is_active = $request->is_active;

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

            return redirect('/supir')->with('success', 'Data supir berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => 'Terjadi kesalahan saat memperbarui data. Pesan: ' . $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $supir = Supir::findOrFail($id);
            $supir->delete();

            return redirect()->route('supir.index')->with('success', 'Data truk berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data supir: ' . $e->getMessage());
        }
    } 

    public function changePassForm($user_id)
    {
        $user = User::find($user_id);

        return view('supir.change', compact('user'));
    }

    public function changePass(Request $request, $user_id)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::findOrFail($user_id);
            $user->password = Hash::make($request->password);

            $user->save();

            return redirect('/supir')->with('success', 'Password Berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => 'Terjadi kesalahan saat memperbarui data. Pesan: ' . $e->getMessage()]);
        }
    }

    public function verifikasiForm($id)
    {
        $supir = Supir::find($id);
        $truks = Truk::get();

        return view('supir.verifikasi', compact('supir','truks'));
    }

    public function verifikasi(Request $request, $id)
    {
        try {
            $request->validate([
                'is_active' => 'required|boolean',
                'truk_id' => 'nullable|exists:truk,id|required_if:is_active,1',
            ]);

            $supir = Supir::findOrFail($id);
            if($request->is_active == true){
                $supir->truk_id = $request->truk_id;
                $supir->is_active = true;
                $supir->save();

                $user = User::findOrFail($supir->user_id);
                $user->is_active = true;
                $user->save();

                $message = 'Akun Supir berhasil diverifikasi!';
            }else{
                $supir->delete();
                $message = 'Akun Supir berhasil dihapus!';
            }

            return redirect('/supir')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => 'Terjadi kesalahan saat memperbarui data. Pesan: ' . $e->getMessage()]);
        }
    }

    // public function create()
    // {
    //     $truks = Truk::all();
    //     return view('supir.create', compact('truks'));
    // }

    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'truk_id' => 'required|exists:truk,id',
    //             'nama' => 'required|string|max:255',
    //             'telepon' => 'nullable|string|max:50',
    //             'alamat' => 'nullable|string|max:255',
    //             'no_ktp' => 'nullable|string|max:100',
    //             'no_sim' => 'nullable|string|max:100',
    //             'photo_diri' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //             'photo_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //             'photo_sim' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //         ]);

    //         $supir = new Supir();
    //         $supir->truk_id = $request->truk_id;
    //         $supir->user_id = auth()->id(); // jika ingin menyimpan user
    //         $supir->nama = $request->nama;
    //         $supir->telepon = $request->telepon;
    //         $supir->alamat = $request->alamat;
    //         $supir->no_ktp = $request->no_ktp;
    //         $supir->no_sim = $request->no_sim;
    
    //         if ($request->hasFile('photo_diri') && $request->file('photo_diri')->isValid()) {
    //             $file = $request->file('photo_diri');
    //             $filename = time() . '_diri_' . $file->getClientOriginalName();
    //             $destination = public_path('uploads/supir/diri');
    //             if (!file_exists($destination)) mkdir($destination, 0755, true);
    //             $file->move($destination, $filename);
    //             $supir->path_photo_diri = '/uploads/supir/diri/' . $filename;
    //         }
    
    //         if ($request->hasFile('photo_ktp') && $request->file('photo_ktp')->isValid()) {
    //             $file = $request->file('photo_ktp');
    //             $filename = time() . '_ktp_' . $file->getClientOriginalName();
    //             $destination = public_path('uploads/supir/ktp');
    //             if (!file_exists($destination)) mkdir($destination, 0755, true);
    //             $file->move($destination, $filename);
    //             $supir->path_photo_ktp = '/uploads/supir/ktp/' . $filename;
    //         }
    
    //         if ($request->hasFile('photo_sim') && $request->file('photo_sim')->isValid()) {
    //             $file = $request->file('photo_sim');
    //             $filename = time() . '_sim_' . $file->getClientOriginalName();
    //             $destination = public_path('uploads/supir/sim');
    //             if (!file_exists($destination)) mkdir($destination, 0755, true);
    //             $file->move($destination, $filename);
    //             $supir->path_photo_sim = '/uploads/supir/sim/' . $filename;
    //         }
    
    //         $supir->save();
    
    //         return redirect()->route('supir.index')->with('success', 'Data supir berhasil disimpan.');
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Gagal menyimpan data supir: ' . $e->getMessage())->withInput();
    //     }
    // }
}
