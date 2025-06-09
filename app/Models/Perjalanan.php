<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perjalanan extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'perjalanan';

    protected $fillable = [
        'hash',
        'truk_id',
        'supir_id',
        'jalur_slug',
        'kota_tujuan_slug',
        'tanggal_berangkat',
        'tanggal_kembali',
        'uang_pengembalian_tol',
        'muatan',
        'uang_subsidi_tol',
        'uang_kembali',
        'uang_setoran',
        'uang_setoran_tambahan',
        'path_struk_kembali',
        'path_bukti_pembayaran',
        'last_updated_bukti_pembayaran',
        'status_slug',
        'is_done',
    ];

    public function truk()
    {
        return $this->belongsTo(Truk::class);
    }

    public function supir()
    {
        return $this->belongsTo(Supir::class);
    }

    public function departProvinsi()
    {
        return $this->belongsTo(Provinsi::class, 'depart_provinsi_id');
    }

    public function departKota()
    {
        return $this->belongsTo(Kota::class, 'depart_kota_id');
    }

    public function returnProvinsi()
    {
        return $this->belongsTo(Provinsi::class, 'return_provinsi_id');
    }

    public function returnKota()
    {
        return $this->belongsTo(Kota::class, 'return_kota_id');
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class);
    }
}