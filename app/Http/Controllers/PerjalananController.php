<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Perjalanan;
use App\Models\Provinsi;
use App\Models\Supir;
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
        $user = Auth::user();
        $role = $user && $user->role_id ? $user->role->slug : null;
        $isDone = $request->is_done;
        $trukId = $request->truk_id;
        $supirId = $request->supir_id;
        $defaultRangeTanggal = Carbon::now()->startOfMonth()->toDateString() . ' - ' . Carbon::now()->endOfMonth()->toDateString();
        $dateRange = $request->date_range ?? $defaultRangeTanggal;

        $perjalanans = Perjalanan::orderBy('tanggal_berangkat','asc')
            ->when($role == 'supir', function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->when($isDone != null, function ($query) use ($isDone) {
                return $query->where('is_done', $isDone);
            })
            ->when($trukId, function ($query) use ($trukId) {
                return $query->where('truk_id', $trukId);
            })
            ->when($supirId, function ($query) use ($supirId) {
                return $query->where('supir_id', $supirId);
            })
            ->when($dateRange && strpos($dateRange, ' - ') !== false, function ($query) use ($dateRange) {
                [$startDate, $endDate] = explode(' - ', $dateRange);
                return $query->whereBetween('tanggal_berangkat', [$startDate, $endDate]);
            })
            ->get();
        
        $truks = Truk::all();
        $supirs = Supir::active()->get();
    
        // with(['truk','supir','departProvinsi','departKota','returnProvinsi','returnKota'])->

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

        return view('perjalanan.index', [
            'perjalanan' => $perjalananRemap,
            'truks' => $truks,
            'supirs' => $supirs,
            'isDone' => $isDone ?? null,
            'trukId' => $trukId,
            'supirId' => $supirId,
            'dateRange' => $dateRange,
        ]);
        
    }

    public function detail($id)
    {
        $perjalanan = Perjalanan::findOrFail($id);
        
        $perjalananRemap = (object)[
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
            'sisa'             => $perjalanan->is_done == true ? $perjalanan->uang_pengembalian_tol + $perjalanan->uang_subsidi_tol - $perjalanan->uang_kembali : 0,
            'uang_setoran'           => $perjalanan->is_done == true && $perjalanan->uang_setoran ? $perjalanan->uang_setoran : 0,
            'bayaran_supir'    => $perjalanan->is_done == true ? $perjalanan->uang_pengembalian_tol + $perjalanan->uang_subsidi_tol - $perjalanan->uang_kembali - $perjalanan->uang_setoran : 0,

            'path_struk_kembali'      => $perjalanan->path_struk_kembali ? $perjalanan->path_struk_kembali : null,
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
        $jalurs = config('constants.jalur');

        return view('perjalanan.form', compact('perjalanan','jalurs'));
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
                'tanggal_berangkat' => 'required|date',
                'tanggal_kembali' => 'nullable|date',
                'uang_pengembalian_tol' => 'nullable|numeric',
                'uang_kembali' => 'nullable|numeric',
                'jalur' => 'nullable|in:full-tol,setengah-tol,bawah',
                'is_done' => 'nullable|boolean',
            ];

            if (in_array($role, ['owner', 'admin'])) {
                $rules['truk_id'] = 'required|exists:truk,id';
                $rules['supir_id'] = 'required|exists:supir,id';
            }

            $request->validate($rules);

            $kode = config('constants.kode_jalur.'.$request->jalur) ?? 'XX';
            $tanggal = now()->format('ymd');
            $countToday = Perjalanan::whereDate('created_at', now()->toDateString())->count();       
            $urut = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);        
            $hash = "$kode/$tanggal/$urut";

            Perjalanan::create([
                'hash' => $hash,
                'truk_id' => in_array($role, ['owner', 'admin']) ? $request->truk_id : $trukId,
                'supir_id' => in_array($role, ['owner', 'admin']) ? $request->supir_id : $supirId,
                'tanggal_berangkat' => $request->tanggal_berangkat,
                'tanggal_kembali' => $request->tanggal_kembali,
                'jalur' => $request->jalur,
                'uang_pengembalian_tol' => $request->uang_pengembalian_tol ?? 0,
                'uang_kembali' => $request->uang_kembali ?? 0,
                'uang_subsidi_tol' => config('constants.uang.uang_subsidi_tol') ?? 0,
                'uang_setoran' => config('constants.uang.uang_setoran') ?? 0,
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

        return view('perjalanan.edit', compact('perjalanan'));
    }
    
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal_berangkat' => 'required|date',
                'tanggal_kembali' => 'nullable|date',
                'uang_pengembalian_tol' => 'nullable|numeric',
                'uang_kembali' => 'nullable|numeric',
                'jalur' => 'nullable|in:full-tol,setengah-tol,bawah',
                'is_done' => 'nullable|boolean',
            ]);
    
            $perjalanan = Perjalanan::findOrFail($id);
            $perjalanan->update([
                'tanggal_berangkat' => $request->tanggal_berangkat,
                'tanggal_kembali' => $request->tanggal_kembali,
                'jalur' => $request->jalur,
                'uang_pengembalian_tol' => $request->uang_pengembalian_tol ?? 0,
                'uang_kembali' => $request->uang_kembali ?? 0,
                // 'uang_subsidi_tol' => config('constants.uang.uang_subsidi_tol') ?? 0,
                // 'uang_setoran' => config('constants.uang.uang_setoran') ?? 0,
                'is_done' => $request->is_done ?? false,
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
