<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jalur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jalurs';

    protected $fillable = [
        'nama',
        'slug',
        'uang_pengembalian_tol',
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
