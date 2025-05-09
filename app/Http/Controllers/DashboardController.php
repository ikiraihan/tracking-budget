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

        $data = [
            'title' => 'Dashboard Absensi',
            'arr_year' => $arrYear,
            'default_range' => $startDateRange . ' to ' . $endDateRange,
            'graphValuePerTruk' => $graphValuePerTruk,
            'graphValuePerStatus' => $graphValuePerStatus,
        ];

        return view('dashboard', $data);
    }
}
