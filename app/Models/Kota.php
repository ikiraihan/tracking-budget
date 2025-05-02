<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'kota';

    protected $fillable = [
        'provinsi_id',
        'nama',
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
