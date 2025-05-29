<?php

namespace App\Http\Controllers;

use App\DTOs\GraphDTO;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService,
    ) {
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $role = $user && $user->role_id ? $user->role->slug : null;

        $request->validate([
            'date_range' => 'nullable|string',
        ]);

        if ($request->date_range) {
            [$startDateRange, $endDateRange] = explode(" to ", $request->date_range . " to ");
            $endDateRange = $endDateRange ?: $startDateRange;
            
            $startDateRange = Carbon::parse($startDateRange);
            $endDateRange = Carbon::parse($endDateRange);
        }else{
            $startDateRange = Carbon::now()->startOfMonth();
            $endDateRange = Carbon::now()->endOfMonth();           
        }

        $arrYear = range(max($startDateRange->year, $endDateRange->year), min($startDateRange->year, $endDateRange->year));
        $graphDTO = new GraphDTO($startDateRange,$endDateRange);
    
        $graphValuePerTruk = $this->dashboardService->graphValuePerTruk($graphDTO);
        $graphValuePerStatus = $this->dashboardService->graphValuePerStatus($graphDTO);
        $countVerifikasiDataPerjalanan = $this->dashboardService->countVerifikasiDataPerjalanan();
        $countVerifikasiPembayaranPerjalanan = $this->dashboardService->countVerifikasiPembayaranPerjalanan();


        $data = [
            'title' => 'Dashboard Absensi',
            'role' =>$role,
            'arr_year' => $arrYear,
            'default_range' => $startDateRange . ' to ' . $endDateRange,
            'graphValuePerTruk' => $graphValuePerTruk,
            'graphValuePerStatus' => $graphValuePerStatus,
            'countVerifikasiDataPerjalanan' => $countVerifikasiDataPerjalanan,
            'countVerifikasiPembayaranPerjalanan' => $countVerifikasiPembayaranPerjalanan,
        ];

        return view('dashboard', $data);
    }
}
