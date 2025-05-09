<?php

namespace App\Helpers;

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
}