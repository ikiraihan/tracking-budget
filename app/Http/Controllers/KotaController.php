<?php
namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function getKotaByProvinsi($provinsiId)
    {
        $kotas = Kota::where('provinsi_id', $provinsiId)->get();
        return response()->json(['kotas' => $kotas]);
    }
}
