<?php

namespace App\Http\Controllers;

use App\Helpers\Functions;
use App\Models\Jalur;
use App\Models\Kota;
use App\Models\KotaTujuan;
use App\Models\Perjalanan;
use App\Models\Provinsi;
use App\Models\Status;
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
        $statusSlug = $request->status_slug;
        $trukId = $request->truk_id;
        $supirId = $request->supir_id;
        $defaultRangeTanggal = Carbon::now()->startOfMonth()->toDateString() . ' - ' . Carbon::now()->endOfMonth()->toDateString();
        $dateRange = $request->date_range ?? $defaultRangeTanggal;
        $perjalanans = Perjalanan::orderBy('tanggal_berangkat','asc')
            ->when($role == 'supir', function ($query) use ($user) {
                return $query->where('supir_id', $user->supir->id);
            })
            ->when($statusSlug, function ($query) use ($statusSlug) {
                return $query->where('status_slug', $statusSlug);
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
        $statuses = Status::all();
    
        // with(['truk','supir','departProvinsi','departKota','returnProvinsi','returnKota'])->

        $perjalananRemap = $perjalanans->map(function ($perjalanan) {
            $status = Status::where('slug',$perjalanan->status_slug)->first();
            $statusColor = $status ? Functions::generateColorStatus($status->slug): null;
            $kotaTujuan = KotaTujuan::where('slug',$perjalanan->kota_tujuan_slug)->first(); 
            $jalur = Jalur::where('slug',$perjalanan->jalur_slug)->first(); 
            return (object)[
                'id'              => $perjalanan->id,
                'hash'              => $perjalanan->hash,
                'truk_id'         => $perjalanan->truk_id,
                'truk_nama'      => $perjalanan->truk && $perjalanan->truk->nama ? $perjalanan->truk->nama : null,
                'truk_nopol'      => $perjalanan->truk && $perjalanan->truk->no_polisi ? $perjalanan->truk->no_polisi : null,
                'supir_id'        => $perjalanan->supir_id,
                'supir_nama'      => $perjalanan->supir && $perjalanan->supir->nama ? $perjalanan->supir->nama : null,
                'supir_telepon'   => $perjalanan->supir && $perjalanan->supir->telepon ? $perjalanan->supir->telepon : null,
                'muatan'          => $perjalanan->muatan ? $perjalanan->muatan : null,

                'tanggal_berangkat'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat): null,
                'tanggal_berangkat_format'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat)->translatedFormat('d F Y'): null,
                'tanggal_kembali'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali): null,
                'tanggal_kembali_format'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali)->translatedFormat('d F Y'): null,

                'jalur_nama'        => $jalur ? $jalur->nama : null,
                'jalur_slug'        => $jalur ? $jalur->slug : null,

                'kota_tujuan_nama'        => $kotaTujuan ? $kotaTujuan->nama : null,
                'kota_tujuan_slug'        => $kotaTujuan ? $kotaTujuan->slug : null,

                'uang_pengembalian_tol'           => $perjalanan->uang_pengembalian_tol ? $perjalanan->uang_pengembalian_tol : 0,
                'uang_subsidi_tol'           => $perjalanan->uang_subsidi_tol ? $perjalanan->uang_subsidi_tol : 0,
                'uang_kembali'           => $perjalanan->uang_kembali ? $perjalanan->uang_kembali : 0,
                'sisa'             => $perjalanan->is_done ? $perjalanan->uang_pengembalian_tol + $perjalanan->uang_subsidi_tol - $perjalanan->uang_kembali : 0,
                
                'uang_setoran'           => $perjalanan->uang_setoran ? $perjalanan->uang_setoran : 0,
                'uang_setoran_tambahan'  => $perjalanan->uang_setoran_tambahan ? $perjalanan->uang_setoran_tambahan : 0,
                'total_uang_setoran'  => $perjalanan->uang_setoran + $perjalanan->uang_setoran_tambahan,

                'bayaran_supir'    => $status && $status->slug != 'dalam-perjalanan' ? $perjalanan->uang_pengembalian_tol + $perjalanan->uang_subsidi_tol - $perjalanan->uang_kembali - $perjalanan->uang_setoran - $perjalanan->uang_setoran_tambahan : 0,

                'path_struk_kembali'      => $perjalanan->path_struk_kembali ? $perjalanan->path_struk_kembali : null,
                'path_bukti_pembayaran'      => $perjalanan->path_bukti_pembayaran ? $perjalanan->path_bukti_pembayaran : null,
                
                'status_nama'        => $status ? $status->nama : null,
                'status_slug'        => $status ? $status->slug : null,
                'status_color'       => $statusColor,

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
            'statusSlug' => $statusSlug,
            'statuses' => $statuses,
            'role' => $role
        ]);
        
    }

    public function detail($id)
    {
        try {
            $user = Auth::user();
            $role = $user->role_id ? $user->role->slug : null;
            // $supir = $user->supir ? $user->supir->id : null;
            $perjalanan = Perjalanan::findOrFail($id);
            $status = Status::where('slug',$perjalanan->status_slug)->first();
            $statusColor = $status ? Functions::generateColorStatus($status->slug): null;
            $kotaTujuan = KotaTujuan::where('slug',$perjalanan->kota_tujuan_slug)->first(); 
            $jalur = Jalur::where('slug',$perjalanan->jalur_slug)->first(); 
            
    
            // Check if the authenticated user is a supir and matches the perjalanan's supir_id
            if ( $role == 'supir' && $user->supir->id != $perjalanan->supir_id) {
                throw new Exception('Anda tidak memiliki akses untuk melihat detail perjalanan ini.');
            }
    
            // Remap the perjalanan data
            $perjalananRemap = (object)[
                'id'              => $perjalanan->id,
                'hash'              => $perjalanan->hash,
                'truk_id'         => $perjalanan->truk_id,
                'truk_nama'      => $perjalanan->truk && $perjalanan->truk->nama ? $perjalanan->truk->nama : null,
                'truk_nopol'      => $perjalanan->truk && $perjalanan->truk->no_polisi ? $perjalanan->truk->no_polisi : null,
                'supir_id'        => $perjalanan->supir_id,
                'supir_nama'      => $perjalanan->supir && $perjalanan->supir->nama ? $perjalanan->supir->nama : null,
                'supir_telepon'   => $perjalanan->supir && $perjalanan->supir->telepon ? $perjalanan->supir->telepon : null,
                'muatan'          => $perjalanan->muatan ? $perjalanan->muatan : null,

                'tanggal_berangkat'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat): null,
                'tanggal_berangkat_format'=> $perjalanan->tanggal_berangkat ? Carbon::parse($perjalanan->tanggal_berangkat)->translatedFormat('d F Y'): null,
                'tanggal_kembali'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali): null,
                'tanggal_kembali_format'=> $perjalanan->tanggal_kembali ? Carbon::parse($perjalanan->tanggal_kembali)->translatedFormat('d F Y'): null,

                'jalur_nama'        => $jalur ? $jalur->nama : null,
                'jalur_slug'        => $jalur ? $jalur->slug : null,

                'kota_tujuan_nama'        => $kotaTujuan ? $kotaTujuan->nama : null,
                'kota_tujuan_slug'        => $kotaTujuan ? $kotaTujuan->slug : null,

                'uang_pengembalian_tol'           => $perjalanan->uang_pengembalian_tol ? $perjalanan->uang_pengembalian_tol : 0,
                'uang_subsidi_tol'           => $perjalanan->uang_subsidi_tol ? $perjalanan->uang_subsidi_tol : 0,
                'uang_kembali'           => $perjalanan->uang_kembali ? $perjalanan->uang_kembali : 0,
                'sisa'             => $status && $status->slug != 'dalam-perjalanan' ? $perjalanan->uang_pengembalian_tol + $perjalanan->uang_subsidi_tol - $perjalanan->uang_kembali : 0,
                
                'uang_setoran'           => $perjalanan->uang_setoran ? $perjalanan->uang_setoran : 0,
                'uang_setoran_tambahan'  => $perjalanan->uang_setoran_tambahan ? $perjalanan->uang_setoran_tambahan : 0,
                'total_uang_setoran'  => $perjalanan->uang_setoran + $perjalanan->uang_setoran_tambahan,

                'bayaran_supir'    => $status && $status->slug != 'dalam-perjalanan' ? $perjalanan->uang_pengembalian_tol + $perjalanan->uang_subsidi_tol - $perjalanan->uang_kembali - $perjalanan->uang_setoran - $perjalanan->uang_setoran_tambahan : 0,

                'path_struk_kembali'      => $perjalanan->path_struk_kembali ? $perjalanan->path_struk_kembali : null,
                'path_bukti_pembayaran'      => $perjalanan->path_bukti_pembayaran ? $perjalanan->path_bukti_pembayaran : null,
                
                'status_nama'        => $status ? $status->nama : null,
                'status_slug'        => $status ? $status->slug : null,
                'status_color'       => $statusColor,

                'is_done'      => $perjalanan->is_done ? $perjalanan->is_done : null,

                'pengeluaran' => $perjalanan->pengeluarans,
            ];
    
            return view('perjalanan.detail', [
                'perjalanan' => $perjalananRemap,
            ]);
        } catch (\Exception $e) {
            // Handle other unexpected errors
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
        $muatans = Functions::generateMuatanMerge();
        $muatanOld = null;
        $uangKembaliOld = null;

        return view('perjalanan.form', compact('perjalanan','jalurs','muatans','muatanOld'));
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
                'uang_kembali' => 'required|numeric',
                'muatan' => 'required',
                'photo_struk_kembali' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                // 'is_done' => 'nullable|boolean',
                // 'uang_pengembalian_tol' => 'nullable|numeric|required_if:is_done,1',
                // 'tanggal_kembali' => 'nullable|date|required_if:is_done,1',
                // 'jalur' => 'nullable|in:full-tol,setengah-tol,bawah|required_if:is_done,1',
            ];

            if (in_array($role, ['owner', 'admin'])) {
                $rules['truk_id'] = 'required|exists:truk,id';
                $rules['supir_id'] = 'required|exists:supir,id';
            }

            $request->validate($rules);

            // $kode = config('constants.kode_jalur.'.$request->jalur) ?? 'XX';
            $tanggal = now()->format('ymd');
            $countToday = Perjalanan::withTrashed()->whereDate('created_at', now()->toDateString())->count();       
            $urut = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);        
            $hash = "TB-$tanggal$urut";
            $path = null;
            $setoran = Functions::generateSetoranMuatan($request->muatan);
            $subsidiTol = Functions::generateSubsidiTol($request->muatan);

            if ($request->hasFile('photo_struk_kembali') && $request->file('photo_struk_kembali')->isValid()) {
                $file = $request->file('photo_struk_kembali');
                $filename = time() . '_struk_' . $file->getClientOriginalName();
                $destination = public_path('/uploads/perjalanan/struk');
                if (!file_exists($destination)) mkdir($destination, 0755, true);
                $file->move($destination, $filename);
                $path = '/uploads/perjalanan/struk/' . $filename;
            }

            Perjalanan::create([
                'hash' => $hash,
                'truk_id' => in_array($role, ['owner', 'admin']) ? $request->truk_id : $trukId,
                'supir_id' => in_array($role, ['owner', 'admin']) ? $request->supir_id : $supirId,
                'tanggal_berangkat' => $request->tanggal_berangkat,
                'muatan' => $request->muatan,
                // 'tanggal_kembali' => $request->tanggal_kembali,
                // 'jalur' => $request->jalur,
                // 'uang_pengembalian_tol' => $request->uang_pengembalian_tol ?? 0,
                'uang_kembali' => $request->uang_kembali ?? 0,
                'path_struk_kembali' => $path ?? null,
                'uang_subsidi_tol' => $subsidiTol ?? 0,
                'uang_setoran' => $setoran ?? 0,
                'status_slug' => 'dalam-perjalanan',
                // 'is_done' => $request->is_done ?? false,
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
        $muatans = Functions::generateMuatanMerge();
        $muatanOld = $perjalanan->muatan;
        $uangKembaliOld = $perjalanan->uang_kembali;
        $jalurs = Jalur::all();
        $kotaTujuans = KotaTujuan::all();
        //dd($muatans,$perjalanan->muatan)

        return view('perjalanan.edit', compact('perjalanan','muatans','jalurs','kotaTujuans','muatanOld','uangKembaliOld'));
    }
    
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal_berangkat' => 'required|date',
                'tanggal_kembali' => 'nullable|date',
                'uang_pengembalian_tol' => 'nullable|numeric',
                'uang_kembali' => 'nullable|numeric',
                'jalur_slug' => 'nullable|exists:jalurs,slug',
                'kota_tujuan_slug' => 'nullable|exists:kota_tujuans,slug',
                'photo_struk_kembali' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'is_done' => 'nullable|boolean',

                'pengeluaran.*.id' => 'nullable|string',
                'pengeluaran.*.nama' => 'nullable|string',
                'pengeluaran.*.jumlah' => 'nullable|numeric',
                'pengeluaran.*.photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            ]);

            $perjalanan = Perjalanan::findOrFail($id);
            $uangSetoranTambahan = KotaTujuan::where('slug',$request->kota_tujuan_slug)->value('uang_setoran_tambahan');

            // Upload foto struk kembali
            if ($request->hasFile('photo_struk_kembali') && $request->file('photo_struk_kembali')->isValid()) {
                $file = $request->file('photo_struk_kembali');
                $filename = time() . '_struk_' . $file->getClientOriginalName();
                $destination = public_path('/uploads/perjalanan/struk');
                if (!file_exists($destination)) mkdir($destination, 0755, true);
                $file->move($destination, $filename);
                $path = '/uploads/perjalanan/struk/' . $filename;
            }

            // Update perjalanan
            $perjalanan->update([
                'tanggal_berangkat' => $request->tanggal_berangkat,
                'tanggal_kembali' => $request->tanggal_kembali,
                'jalur_slug' => $request->jalur_slug,
                'kota_tujuan_slug' => $request->kota_tujuan_slug,
                'uang_pengembalian_tol' => $request->uang_pengembalian_tol ?? 0,
                'uang_kembali' => $request->uang_kembali ?? 0,
                'uang_setoran_tambahan' => $uangSetoranTambahan ?? 0,
                'path_struk_kembali' => $path ?? $perjalanan->path_struk_kembali,
                'status_slug' => 'proses-reimburse',
                'is_done' => $request->is_done ?? false,
            ]);

            $submittedIds = collect($request->pengeluaran)->pluck('id')->filter()->toArray();
            $existingIds = $perjalanan->pengeluarans()->pluck('id')->toArray();
            $deletedIds = array_diff($existingIds, $submittedIds);

            if (!empty($deletedIds)) {
                $perjalanan->pengeluarans()->whereIn('id', $deletedIds)->delete();
            }

            foreach ($perjalanan->pengeluarans()->whereIn('id', $deletedIds)->get() as $p) {
                if ($p->path_photo && file_exists(public_path($p->path_photo))) {
                    unlink(public_path($p->path_photo));
                }
            }

            if ($request->has('pengeluaran')) {
                foreach ($request->pengeluaran as $index => $item) {
                    if (empty($item['nama']) || empty($item['jumlah'])) {
                        continue;
                    }
                    $pengeluaranPath = null;
                    if ($request->hasFile("pengeluaran.{$index}.photo") && $request->file("pengeluaran.{$index}.photo")->isValid()) {
                        $file = $request->file("pengeluaran.{$index}.photo");
                        $filename = time() . "_pengeluaran_{$index}_" . $file->getClientOriginalName();
                        $destination = public_path('/uploads/perjalanan/pengeluaran');
                        if (!file_exists($destination)) mkdir($destination, 0755, true);
                        $file->move($destination, $filename);
                        $pengeluaranPath = '/uploads/perjalanan/pengeluaran/' . $filename;
                    }

                    if (isset($item['id'])) {
                        $pengeluaran = $perjalanan->pengeluarans()->where('id', $item['id'])->first();

                        if ($pengeluaran) {
                            $pengeluaran->update([
                                'nama' => $item['nama'],
                                'uang_pengeluaran' => $item['jumlah'],
                                'path_photo' => $pengeluaranPath ?? $pengeluaran->path_photo,
                            ]);
                        }
                    } else {
                        $perjalanan->pengeluarans()->create([
                            'perjalanan_id' => $perjalanan->id,
                            'truk_id' => $perjalanan->truk_id,
                            'supir_id' => $perjalanan->supir_id,
                            'nama' => $item['nama'],
                            'uang_pengeluaran' => $item['jumlah'],
                            'path_photo' => $pengeluaranPath,
                        ]);
                    }
                }
            }

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
