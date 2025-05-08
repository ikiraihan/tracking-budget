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
            $startDateRange = Carbon::now()->subMonth()->day(26);
            $endDateRange = Carbon::now()->day(25);           
        }

        $arrYear = range(max($startDateRange->year, $endDateRange->year), min($startDateRange->year, $endDateRange->year));
        $graphDTO = new GraphDTO($startDateRange,$endDateRange);
        
        // $user = Auth::user();
        // $role = $user->role_id ? $user->role->slug : null;
        //$arrYear = [2025,2024];
        // switch($role){
        //     case'admin':
        //     case'owner':
        //         $graphDTO = new GraphDTO($startDateRange,$endDateRange);
        //         break;
        //     default:
        //         $supirId = $user->supir ? $user->supir->id : null;
        //         $graphDTO = new GraphDTO($startDateRange,$endDateRange,$user->id,$supirId);
        //         break;
        // }

        $graphValuePerTruk = $this->dashboardService->graphValuePerTruk($graphDTO);

        $data = [
            'title' => 'Dashboard Absensi',
            'arr_year' => $arrYear,
            'default_range' => $startDateRange . ' to ' . $endDateRange,
            'graphValuePerTruk' => $graphValuePerTruk,
        ];

        return view('dashboard', $data);
    }
}
