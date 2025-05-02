<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Perjalanan;
use App\Models\Provinsi;
use App\Models\Truk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class PerjalananController extends Controller
{
    public function index(Request $request)
    {
        $isDone = $request->is_done;
        $trukId = $request->truk_id;
        $defaultRangeTanggal = Carbon::now()->startOfMonth()->toDateString() . ' - ' . Carbon::now()->endOfMonth()->toDateString();
        $dateRange = $request->date_range ?? $defaultRangeTanggal;

        $perjalanans = Perjalanan::query()
            ->when($isDone != null, function ($query) use ($isDone) {
                return $query->where('is_done', $isDone);
            })
            ->when($trukId, function ($query) use ($trukId) {
                return $query->where('truk_id', $trukId);
            })
            ->when($dateRange && strpos($dateRange, ' - ') !== false, function ($query) use ($dateRange) {
                [$startDate, $endDate] = explode(' - ', $dateRange);
                return $query->whereBetween('tanggal_berangkat', [$startDate, $endDate]);
            })
            ->get();
        
        $truks = Truk::all();
    
        // with(['truk','supir','departProvinsi','departKota','returnProvinsi','returnKota'])->

        $perjalananRemap = $perjalanans->map(function ($perjalanan) {
            return (object)[
                'id'              => $perjalanan->id,
                'truk_id'         => $perjalanan->truk_id,
                'truk_nama'      => $perjalanan->truk && $perjalanan->truk->nama ? $perjalanan->truk->nama : null,
                'truk_nopol'      => $perjalanan->truk && $perjalanan->truk->no_polisi ? $perjalanan->truk->no_polisi : null,
                'supir_id'        => $perjalanan->supir_id,
                'supir_nama'      => $perjalanan->supir && $perjalanan->supir->nama ? $perjalanan->supir->nama : null,
                'supir_telepon'      => $perjalanan->supir && $perjalanan->supir->telepon ? $perjalanan->supir->telepon : null,
                'depart_provinsi_id'   => $perjalanan->depart_provinsi_id,
                'depart_provinsi_nama' => $perjalanan->departProvinsi && $perjalanan->departProvinsi->nama ? $perjalanan->departProvinsi->nama : null,
                'depart_kota_id'   => $perjalanan->depart_kota_id,
                'depart_kota_nama' => $perjalanan->departKota && $perjalanan->departKota->nama ? $perjalanan->departKota->nama : null,
                'return_provinsi_id'   => $perjalanan->return_provinsi_id,
                'return_provinsi_nama' => $perjalanan->returnProvinsi && $perjalanan->returnProvinsi->nama ? $perjalanan->returnProvinsi->nama : null,
                'return_kota_id'   => $perjalanan->return_kota_id,
                'return_kota_nama' => $perjalanan->returnKota && $perjalanan->returnKota->nama ? $perjalanan->returnKota->nama : null,
                'tanggal_berangkat'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat): null,
                'tanggal_berangkat_format'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat)->translatedFormat('d F Y'): null,
                'tanggal_kembali'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali): null,
                'tanggal_kembali_format'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali)->translatedFormat('d F Y'): null,

                'budget'           => $perjalanan->budget ? $perjalanan->budget : null,
                'income'           => $perjalanan->income ? $perjalanan->income : null,
                'expenditure'      => $perjalanan->expenditure ? $perjalanan->expenditure : null,

                'total'            => $perjalanan->budget + $perjalanan->income - $perjalanan->expenditure,
                
                'is_done'      => $perjalanan->is_done ? $perjalanan->is_done : null,
            ];
        });

        return view('perjalanan.index', [
            'perjalanan' => $perjalananRemap,
            'truks' => $truks,
            'isDone' => $isDone ?? null,
            'trukId' => $trukId,
            'dateRange' => $dateRange,
        ]);
        
    }

    public function detail($id)
    {
        $perjalanan = Perjalanan::findOrFail($id);
        
        $perjalananRemap = (object)[
            'id'              => $perjalanan->id,
            'truk_id'         => $perjalanan->truk_id,
            'truk_nama'      => $perjalanan->truk && $perjalanan->truk->nama ? $perjalanan->truk->nama : null,
            'truk_nopol'      => $perjalanan->truk && $perjalanan->truk->no_polisi ? $perjalanan->truk->no_polisi : null,
            'supir_id'        => $perjalanan->supir_id,
            'supir_nama'      => $perjalanan->supir && $perjalanan->supir->nama ? $perjalanan->supir->nama : null,
            'supir_telepon'      => $perjalanan->supir && $perjalanan->supir->telepon ? $perjalanan->supir->telepon : null,
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

        return view('perjalanan.detail', [
            'perjalanan' => $perjalananRemap,
        ]);
    }
    
    public function formIndex()
    {
        // Ambil data perjalanan beserta relasi-relasinya
        $perjalanan = Perjalanan::with([
            'truk', 
            'supir', 
            'departProvinsi', 
            'departKota', 
            'returnProvinsi', 
            'returnKota'
        ])->get();
        $provinsis = Provinsi::all();
        $kotas = Kota::all();

        return view('perjalanan.form', compact('perjalanan','provinsis','kotas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->slug;
        $supirId = $user->supir && $user->supir->id ? $user->supir->id : null;
        $trukId = $user->supir && $user->supir->truk_id ? $user->supir->truk_id : null;

        try {
            DB::beginTransaction();

            $rules = [
                // 'depart_provinsi_id' => 'required|exists:provinsi,id',
                'depart_kota_id' => 'required|exists:kota,id',
                // 'return_provinsi_id' => 'required|exists:provinsi,id',
                'return_kota_id' => 'required|exists:kota,id',
                'tanggal_berangkat' => 'required|date',
                'budget' => 'required|numeric',
                'income' => 'nullable|numeric',
                'tanggal_kembali' => 'nullable|date',
                'expenditure' => 'nullable|numeric',
                'is_done' => 'nullable|boolean',
            ];

            if (in_array($role, ['owner', 'admin'])) {
                $rules['truk_id'] = 'required|exists:truk,id';
                $rules['supir_id'] = 'required|exists:supir,id';
            }

            $request->validate($rules);

            Perjalanan::create([
                'truk_id' => in_array($role, ['owner', 'admin']) ? $request->truk_id : $trukId,
                'supir_id' => in_array($role, ['owner', 'admin']) ? $request->supir_id : $supirId,
                'depart_provinsi_id' => $request->depart_provinsi_id,
                'depart_kota_id' => $request->depart_kota_id,
                'return_provinsi_id' => $request->return_provinsi_id,
                'return_kota_id' => $request->return_kota_id,
                'tanggal_berangkat' => $request->tanggal_berangkat,
                'tanggal_kembali' => $request->tanggal_kembali,
                'budget' => $request->budget,
                'income' => $request->income ?? 0,
                'expenditure' => $request->expenditure ?? 0,
                'is_done' => $request->is_done ?? false,
            ]);

            DB::commit();
            
            return redirect()->back()->with('success', 'Perjalanan berhasil disimpan!');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

        
    public function edit($id)
    {
        $perjalanan = Perjalanan::findOrFail($id);
        $kotas = Kota::all();

        return view('perjalanan.edit', compact('perjalanan','kotas'));
    }
    
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'depart_kota_id' => 'required|exists:kota,id',
                'return_kota_id' => 'required|exists:kota,id',
                'tanggal_berangkat' => 'required|date',
                'budget' => 'required|numeric|min:0',
                'is_done' => 'nullable|boolean',
                'tanggal_kembali' => 'nullable|date|required_if:is_done,1',
                'expenditure' => 'nullable|numeric|min:0|required_if:is_done,1',
                'income' => 'nullable|numeric|min:0|required_if:is_done,1',
            ]);
    
            $perjalanan = Perjalanan::findOrFail($id);
            $perjalanan->update([
                'depart_kota_id' => $request->depart_kota_id,
                'return_kota_id' => $request->return_kota_id,
                'tanggal_berangkat' => $request->tanggal_berangkat,
                'budget' => $request->budget,
                'is_done' => $request->is_done ?? 0,
                'tanggal_kembali' => $request->is_done ? $request->tanggal_kembali : null,
                'expenditure' => $request->is_done ? $request->expenditure : 0,
                'income' => $request->is_done ? $request->income : 0,
            ]);
    
            return redirect()->route('perjalanan.index')->with('success', 'Data perjalanan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $perjalanan = Perjalanan::findOrFail($id);
            $perjalanan->delete();

            return redirect()->route('perjalanan.index')->with('success', 'Data perjalanan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data perjalanan: ' . $e->getMessage());
        }
    } 
}
