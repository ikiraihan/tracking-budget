<?php

namespace App\Http\Controllers;

use App\Models\Perjalanan;
use App\Models\Truk;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrukController extends Controller
{
    public function index()
    {
        $truks = Truk::get();

        return view('truk.index', compact('truks'));
    }

    public function detail($id,Request $request)
    {
        $truk = Truk::findOrFail($id);
        $perjalanans = Perjalanan::where('truk_id',$id)->get();
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

        return view('truk.detail', [
            'truk' => $truk,
            'perjalanans' => $perjalananRemap,
            'supir_nama' => $supirString,
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
            ]);

            $cekNoPol = Truk::where('no_polisi',$request->no_polisi)->first();
            if ($cekNoPol) {
                throw new \Exception("Nomor polisi sudah terdaftar.");
            }

            $truk = new Truk();
            $truk->no_polisi = $request->no_polisi;
            $truk->nama = $request->nama;

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
        ]);
    
        try {
            $truk = Truk::findOrFail($id);
    
            $truk->no_polisi = $request->no_polisi;
            $truk->nama = $request->nama;
    
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