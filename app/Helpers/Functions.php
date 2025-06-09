<?php

namespace App\Helpers;

use App\Models\Perjalanan;

class Functions
{
    public static function generateRandomColorsTruk($count) {
        // Static array of 100 distinct RGB colors
        static $predefinedColors = [
            'rgb(255,0,0)', 'rgb(255,128,0)', 'rgb(255,255,0)', 'rgb(128,255,0)', 'rgb(38,115,153)', 'rgb(38,38,153)',
            'rgb(0,255,0)', 'rgb(0,255,128)', 'rgb(0,255,255)', 'rgb(0,128,255)', 'rgb(0,0,255)', 'rgb(128,0,255)',
            'rgb(255,0,128)', 'rgb(255,64,64)', 'rgb(255,191,64)', 'rgb(191,255,64)', 'rgb(64,255,64)',
            'rgb(64,255,191)', 'rgb(64,191,255)', 'rgb(64,64,255)', 'rgb(191,64,255)', 'rgb(255,64,191)',
            'rgb(204,0,0)', 'rgb(204,102,0)', 'rgb(204,204,0)', 'rgb(102,204,0)', 'rgb(0,204,0)',
            'rgb(0,204,102)', 'rgb(0,204,204)', 'rgb(0,102,204)', 'rgb(0,0,204)', 'rgb(102,0,204)',
            'rgb(204,0,102)', 'rgb(204,51,51)', 'rgb(204,153,51)', 'rgb(153,204,51)', 'rgb(51,204,51)',
            'rgb(51,204,153)', 'rgb(51,153,204)', 'rgb(51,51,204)', 'rgb(153,51,204)', 'rgb(204,51,153)',
            'rgb(153,0,0)', 'rgb(153,76,0)', 'rgb(153,153,0)', 'rgb(76,153,0)', 'rgb(0,153,0)',
            'rgb(0,153,76)', 'rgb(0,153,153)', 'rgb(0,76,153)', 'rgb(0,0,153)', 'rgb(76,0,153)',
            'rgb(153,0,76)', 'rgb(153,38,38)', 'rgb(153,115,38)', 'rgb(115,153,38)', 'rgb(38,153,38)',
            'rgb(38,153,115)', 'rgb(115,38,153)', 'rgb(153,38,115)',
            'rgb(102,0,0)', 'rgb(102,51,0)', 'rgb(102,102,0)', 'rgb(51,102,0)', 'rgb(0,102,0)',
            'rgb(0,102,51)', 'rgb(0,102,102)', 'rgb(0,51,102)', 'rgb(0,0,102)', 'rgb(51,0,102)',
            'rgb(102,0,51)', 'rgb(102,25,25)', 'rgb(102,76,25)', 'rgb(76,102,25)', 'rgb(25,102,25)',
            'rgb(25,102,76)', 'rgb(25,76,102)', 'rgb(25,25,102)', 'rgb(76,25,102)', 'rgb(102,25,76)',
            'rgb(51,0,0)', 'rgb(51,25,0)', 'rgb(51,51,0)', 'rgb(25,51,0)', 'rgb(0,51,0)',
            'rgb(0,51,25)', 'rgb(0,51,51)', 'rgb(0,25,51)', 'rgb(0,0,51)', 'rgb(25,0,51)',
            'rgb(51,0,25)', 'rgb(51,13,13)', 'rgb(51,38,13)', 'rgb(38,51,13)', 'rgb(13,51,13)',
            'rgb(13,51,38)', 'rgb(13,38,51)', 'rgb(13,13,51)', 'rgb(38,13,51)', 'rgb(51,13,38)'
        ];
    
        // Ensure $count is positive and handle cases where $count > 100
        $count = max(1, min($count, 100)); // Limit to 1-100
        $colors = [];
    
        // Return the requested number of colors
        for ($i = 0; $i < $count; $i++) {
            $colors[] = $predefinedColors[$i % count($predefinedColors)]; // Cycle if $count > 100
        }
    
        return $colors;
    }

    public static function generateSetoranMuatan($muatan) {
    
        $muatan = strtolower($muatan);
        switch($muatan){
            case'cnj':
                $setoran = config('constants.setoran_muatan.CNJ');
                break;
            case'stj':
                $setoran = config('constants.setoran_muatan.STJ');
                break;
            default:
                $setoran = config('constants.setoran_muatan.lainnya');
                break;
        }
        return $setoran;
    }
    public static function generateSubsidiTol($muatan) {
        $muatan = strtolower($muatan);
        switch($muatan){
            case'cnj':
                $setoran = config('constants.subsidi_tol.CNJ');
                break;
            case'stj':
                $setoran = config('constants.subsidi_tol.STJ');
                break;
            default:
                $setoran = config('constants.subsidi_tol.lainnya');
                break;
        }
        return $setoran;
    }
    public static function generateColorStatus($statusSlug) {
    
        switch($statusSlug){
            case'dalam-perjalanan':
                $color = "bg-primary";
                break;
            case'proses-reimburse':
                $color = "bg-orange";
                break;
            case'proses-pembayaran':
                $color = "bg-teal";
                break;
            case'selesai':
                $color = "bg-success";
                break;
            default:
                $color = "bg-success";
                break;
        }
        return $color;
    }

    public static function generateColorStatusRGB($statusSlug)
    {
        switch($statusSlug){
            case'dalam-perjalanan':
                $color = "rgb(0,0,204)";
                break;
            case'proses-reimburse':
                $color = "rgb(229, 115, 1)";
                break;
            case'proses-pembayaran':
                $color = "rgba(0, 204, 204, 0.74)";
                break;
            case'selesai':
                $color = "rgb(0,102,0)";
                break;
            default:
                $color = "rgb(0,102,0)";
                break;
        }
        return $color;
    }

    public static function generateMuatanMerge() 
    {
        // $semuaMuatan = Perjalanan::pluck('muatan')->toArray();

        // $semuaMuatanArray = [];
        // foreach ($semuaMuatan as $item) {
        //     $parts = explode(',', $item);
        //     $trimmed = array_map('trim', $parts);
        //     $semuaMuatanArray = array_merge($semuaMuatanArray, $trimmed);
        // }
        $muatanDefault = config('constants.muatan');
        // $customMuatan = array_diff($semuaMuatanArray, $muatanDefault);
        // $muatanCustomUnique = array_values(array_unique($customMuatan));
        // $muatanMerged = array_values(array_unique(array_merge($muatanDefault, $muatanCustomUnique)));

        return $muatanDefault;

    }
}