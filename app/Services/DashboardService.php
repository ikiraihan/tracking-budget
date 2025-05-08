<?php

namespace App\Services;

use App\DTOs\GraphDTO;
use App\Helpers\Functions;
use App\Models\Absensi;
use App\Models\AbsensiHarian;
use App\Models\HariLibur;
use App\Models\KeteranganAbsensi;
use App\Models\Perjalanan;
use App\Models\Truk;

class DashboardService
{ 
    public static function graphValuePerTruk(GraphDTO $dto)
    {
        $startDate = $dto->startDate->startOfDay();
        $endDate = $dto->endDate->endOfDay();
    
        $absensiHarians = Perjalanan::whereBetween('tanggal_berangkat', [$startDate, $endDate])
            ->get();
    
        $truks = Truk::where('is_active',true)->get();
        $randomColors = Functions::generateRandomColors($truks->count());
    
        // Buat data
        $data = collect(
            $truks->map(fn($truk,$index) => (object) [
                'nama'  => $truk->nama ?? '-',
                'slug'  => $truk->slug ?? '-',
                'count' => $absensiHarians->where('truk_id', $truk->id)->count(),
                'color' => $randomColors[$index],
            ])
        );
    
        return $data;
    }   
}