<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user && $user->role_id ? $user->role->slug : null;

        if ($request->date_range) {
            [$startDateRange, $endDateRange] = explode(" to ", $request->date_range . " to ");
            $endDateRange = $endDateRange ?: $startDateRange;
            
            $startDateRange = Carbon::parse($startDateRange);
            $endDateRange = Carbon::parse($endDateRange);
        }else{
            $startDateRange = Carbon::parse('2025-01-01');
            $endDateRange = Carbon::now()->endOfMonth();         
        }
        $dateRange = $startDateRange . ' to ' . $endDateRange;
        $pengeluarans = Pengeluaran::selectRaw('pengeluaran.truk_id, truk.nama, SUM(pengeluaran.uang_pengeluaran) as uang_pengeluaran')
            ->join('truk', 'truk.id', '=', 'pengeluaran.truk_id')
            ->when($startDateRange && $endDateRange !== false, function ($query) use ($startDateRange,$endDateRange) {
                return $query->whereHas('perjalanan', function ($q) use ($startDateRange, $endDateRange) {
                    $q->whereBetween('tanggal_berangkat', [$startDateRange, $endDateRange]);
                });
            })
            ->groupBy('pengeluaran.truk_id', 'truk.nama')
            ->get();

        return view('pengeluaran.index', compact('pengeluarans','dateRange'));
    }

    public function show($truk_id,Request $request)
    {
        if ($request->date_range) {
            [$startDateRange, $endDateRange] = explode(" to ", $request->date_range . " to ");
            $endDateRange = $endDateRange ?: $startDateRange;
            
            $startDateRange = Carbon::parse($startDateRange);
            $endDateRange = Carbon::parse($endDateRange);
        }else{
            $startDateRange = Carbon::parse('2025-01-01');
            $endDateRange = Carbon::now()->endOfMonth();         
        }

        $pengeluarans = Pengeluaran::where('truk_id',$truk_id)
            ->when($startDateRange && $endDateRange !== false, function ($query) use ($startDateRange,$endDateRange) {
                return $query->whereHas('perjalanan', function ($q) use ($startDateRange, $endDateRange) {
                    $q->whereBetween('tanggal_berangkat', [$startDateRange, $endDateRange]);
                });
            })
            ->get();
        
        $pengeluaranRemap = $pengeluarans->map(function ($pengeluaran) {
            $perjalanan = $pengeluaran->perjalanan ? $pengeluaran->perjalanan : null;
            return (object)[
                'id'               => $pengeluaran->id,
                'perjalanan_id'  => $perjalanan ? $perjalanan->id : null,
                'perjalanan_hash'  => $perjalanan ? $perjalanan->hash : null,
                'nama'             => $pengeluaran->nama,
                'uang_pengeluaran' => $pengeluaran->uang_pengeluaran,
                'path_photo'       => $pengeluaran->path_photo,
            ];
        });

        return response()->json(['message' => 'success','pengeluarans'=>$pengeluaranRemap]);
    }
}
