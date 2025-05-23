<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengeluaran';

    protected $fillable = [
        'perjalanan_id',
        'truk_id',
        'supir_id',
        'nama',
        'deskripsi',
        'uang_pengeluaran',
        'path_photo',
    ];

    public function perjalanan() {
        return $this->belongsTo(Perjalanan::class);
    }
}
