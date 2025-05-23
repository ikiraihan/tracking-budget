<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KotaTujuan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kota_tujuans';

    protected $fillable = [
        'nama',
        'slug',
        'tambahan_uang_setoran',
        'is_active',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeInActive($query)
    {
        return $query->where('is_active', true);
    }
}
