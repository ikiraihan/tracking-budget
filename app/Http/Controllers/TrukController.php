<?php

namespace App\Http\Controllers;

use App\Models\Perjalanan;
use App\Models\Truk;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrukController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user && $user->role_id ? $user->role->slug : null;
        $truks = Truk::where('is_active',true)->get();
        $trukInactives = Truk::where('is_active',false)->get();

        return view('truk.index', compact('truks','trukInactives','role'));
    }

    public function detail($id,Request $request)
    {
        $defaultRangeTanggal = Carbon::now()->startOfMonth()->toDateString() . ' - ' . Carbon::now()->endOfMonth()->toDateString();
        $dateRange = $request->date_range ?? $defaultRangeTanggal;
        $isDone = $request->is_done;
        $supirId = $request->supir_id;

        $truk = Truk::findOrFail($id);
        $perjalanans = Perjalanan::where('truk_id',$id)
        ->when($dateRange && strpos($dateRange, ' - ') !== false, function ($query) use ($dateRange) {
            [$startDate, $endDate] = explode(' - ', $dateRange);
            return $query->whereBetween('tanggal_berangkat', [$startDate, $endDate]);
        })
        ->when($isDone != null, function ($query) use ($isDone) {
            return $query->where('is_done', $isDone);
        })
        ->when($supirId != null, function ($query) use ($supirId) {
            return $query->where('supir_id', $supirId);
        })->get();

        $supirs = $truk->supirs->where('is_active', true);
        $supirNames = $supirs->pluck('nama')->values();       
        $supirString = match ($supirNames->count()) {
            0 => '',
            1 => $supirNames[0],
            2 => $supirNames[0] . ' dan ' . $supirNames[1],
            default => $supirNames->slice(0, -1)->implode(', ') . ', dan ' . $supirNames->last()
        };
        
        $perjalananRemap = $perjalanans->map(function ($perjalanan) {
            return (object)[
                'id'              => $perjalanan->id,
                'hash'              => $perjalanan->hash,
                'truk_id'         => $perjalanan->truk_id,
                'truk_nama'      => $perjalanan->truk && $perjalanan->truk->nama ? $perjalanan->truk->nama : null,
                'truk_nopol'      => $perjalanan->truk && $perjalanan->truk->no_polisi ? $perjalanan->truk->no_polisi : null,
                'supir_id'        => $perjalanan->supir_id,
                'supir_nama'      => $perjalanan->supir && $perjalanan->supir->nama ? $perjalanan->supir->nama : null,
                'supir_telepon'      => $perjalanan->supir && $perjalanan->supir->telepon ? $perjalanan->supir->telepon : null,
                'jalur'      => $perjalanan->jalur ? $perjalanan->jalur : null,

                'tanggal_berangkat'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat): null,
                'tanggal_berangkat_format'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat)->translatedFormat('d F Y'): null,
                'tanggal_kembali'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali): null,
                'tanggal_kembali_format'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali)->translatedFormat('d F Y'): null,

                'uang_pengembalian_tol'           => $perjalanan->uang_pengembalian_tol ? $perjalanan->uang_pengembalian_tol : 0,
                'uang_subsidi_tol'           => $perjalanan->uang_subsidi_tol ? $perjalanan->uang_subsidi_tol : 0,
                'uang_kembali'           => $perjalanan->uang_kembali ? $perjalanan->uang_kembali : 0,
                'sisa'             => $perjalanan->uang_pengembalian_tol + $perjalanan->uang_subsidi_tol - $perjalanan->uang_kembali,
                'uang_setoran'           => $perjalanan->uang_setoran ? $perjalanan->uang_setoran : 0,
                'bayaran_supir'    => $perjalanan->uang_pengembalian_tol + $perjalanan->uang_subsidi_tol - $perjalanan->uang_kembali - $perjalanan->uang_setoran,

                'path_struk_kembali'      => $perjalanan->path_struk_kembali ? $perjalanan->path_struk_kembali : null,
                'is_done'      => $perjalanan->is_done ? $perjalanan->is_done : null,
            ];
        });

        return view('truk.detail', [
            'truk' => $truk,
            'perjalanans' => $perjalananRemap,
            'supir_nama' => $supirString,
            'supirs' => $supirs,
            'supirId' => $supirId,
            'dateRange' => $dateRange,
            'isDone' => $isDone,
        ]);
    }

    public function create()
    {
        return view('truk.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'no_polisi' => 'required|string|max:255',
                'nama' => 'required|string|max:255',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'is_active' => 'nullable|boolean',
            ]);

            $cekNoPol = Truk::where('no_polisi',$request->no_polisi)->first();
            if ($cekNoPol) {
                throw new \Exception("Nomor polisi sudah terdaftar.");
            }

            $truk = new Truk();
            $truk->no_polisi = $request->no_polisi;
            $truk->nama = $request->nama;
            $truk->is_active = $request->is_active;

            if ($request->hasFile('photo')) {
    
                // Simpan foto ke public/uploads/truk
                $file = $request->file('photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destination = public_path('uploads/truk');
                $file->move($destination, $filename);
    
                // Simpan path relatif
                $truk->path_photo = '/uploads/truk/' . $filename;
            }

            $truk->save();

            return redirect()->route('truk.index')->with('success', 'Data truk berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data truk: ' . $e->getMessage())->withInput();
        }
    }
    
    public function edit($id)
    {
        $truk = Truk::findOrFail($id);

        return view('truk.edit', compact('truk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_polisi' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'nullable|boolean',
        ]);
    
        try {
            $truk = Truk::findOrFail($id);
    
            $truk->no_polisi = $request->no_polisi;
            $truk->nama = $request->nama;
            $truk->is_active = $request->is_active;
    
            if ($request->hasFile('photo')) {
                // Hapus foto lama jika ada
                if ($truk->path_photo && file_exists(public_path($truk->path_photo))) {
                    unlink(public_path($truk->path_photo));
                }
    
                // Simpan foto ke public/uploads/truk
                $file = $request->file('photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destination = public_path('uploads/truk');
                $file->move($destination, $filename);
    
                // Simpan path relatif
                $truk->path_photo = '/uploads/truk/' . $filename;
            }
    
            $truk->save();
    
            return redirect()->route('truk.index')->with('success', 'Data truk berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data truk.');
        }
    }

    public function delete($id)
    {
        try {
            $truk = Truk::findOrFail($id);

            // $truk->is_active = 0;
            // $truk->save();
            $truk->delete();

            return redirect()->route('truk.index')->with('success', 'Data truk berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data truk: ' . $e->getMessage());
        }
    }      
}