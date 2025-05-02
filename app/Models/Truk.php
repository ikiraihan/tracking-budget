<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'truk';

    protected $fillable = [
        'no_polisi',
        'nama',
        'path_photo',
    ];

    public function supirs()
    {
        return $this->hasMany(Supir::class);
    }

    public function perjalanans()
    {
        return $this->hasMany(Perjalanan::class);
    }
}
