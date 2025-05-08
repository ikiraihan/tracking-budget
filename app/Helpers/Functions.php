<?php

namespace App\Helpers;

class Functions
{
    public static function generateRandomColors($count) {
        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            // Generate random RGB values
            $red = mt_rand(0, 255);
            $green = mt_rand(0, 255);
            $blue = mt_rand(0, 255);
            // Format as rgb(r,g,b)
            $colors[] = "rgb($red,$green,$blue)";
        }
        return $colors;
    }
}