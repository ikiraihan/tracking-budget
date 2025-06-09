<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supir extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'supir';

    protected $fillable = [
        'truk_id',
        'user_id',
        'nama',
        'telepon',
        'alamat',
        'no_ktp',
        'no_sim',
        'nama_bank',
        'rekening',
        'path_photo_diri',
        'path_photo_ktp',
        'path_photo_sim',
        'is_active',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function truk()
    {
        return $this->belongsTo(Truk::class);
    }

    public function perjalanans()
    {
        return $this->hasMany(Perjalanan::class);
    }

    protected static function booted()
    {
        static::updated(function (Supir $supir) {
            if ($supir->isDirty('nama') && $supir->user) {
                $supir->user->name = $supir->nama;
                $supir->user->save();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
