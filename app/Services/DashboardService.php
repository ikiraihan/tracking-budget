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
        $randomColors = Functions::generateRandomColorsTruk($truks->count());
    
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
    
    public static function graphValuePerStatus(GraphDTO $dto)
    {
        $startDate = $dto->startDate->startOfDay();
        $endDate = $dto->endDate->endOfDay();
    
        $perjalanans = Perjalanan::whereBetween('tanggal_berangkat', [$startDate, $endDate])
            ->get();
    
        $statuses = [0, 1];

        // Map statuses to data
        $data = collect($statuses)->map(function ($status) use ($perjalanans) {
            return (object) [
                'nama'  => $status ? 'Selesai' : 'Belum Selesai',
                'slug'  => $status ? 'selesai' : 'belum-selesai',
                'count' => $perjalanans->where('is_done', $status)->count(),
                'color' => $status ? 'rgb(38,153,38)' : 'rgb(204,0,0)',
            ];
        });

    
        return $data;
    }   

    // public static function graphBarValueKehadiranPerBulan(GraphDTO $dto)
    // {
    //     $startDate = $dto->startDate->startOfDay();
    //     $endDate = $dto->endDate->endOfDay();
    //     $userId = $dto->userId;
    //     $year = max($startDate->year, $endDate->year);
        
    //     // Ambil semua absensi dalam satu query untuk tahun yang diproses
    //     $absensiHarians = AbsensiHarian::when($userId, function ($query) use ($userId) {
    //             return $query->where('user_id', $userId);
    //         })
    //         ->whereYear('tanggal_kerja', $year)
    //         ->get()
        
    //     $keteranganAbsensis = KeteranganAbsensi::orderBy('id','asc')->get();
        
    //     return collect(range(1, 12))->map(function ($month) use ($year, $absensiHarians, $keteranganAbsensis) {
    //         $date = Carbon::create($year, $month, 1);
            
    //         $dataKeterangan = $keteranganAbsensis->map(function ($keterangan) use ($absensiHarians, $month) {
    //             // Pastikan $absensiHarians[$month] tidak null
    //             $absensiData = $absensiHarians[$month] ?? collect();
    
    //             return (object) [
    //                 'nama'  => $keterangan->nama ?? '-',
    //                 'slug'  => $keterangan->slug ?? '-',
    //                 'count' => $absensiData->where('keterangan_id', $keterangan->id)->count(),
    //                 'color' => Functions::generateColorForKeteranganAbsensi($keterangan->slug),
    //             ];
    //         });
    
    //         return (object) [
    //             'year'  => $year,
    //             'month' => $month,
    //             'month_text' => $date->translatedFormat('F'),
    //             'data' => $dataKeterangan,
    //         ];
    //     });
    // }  
}