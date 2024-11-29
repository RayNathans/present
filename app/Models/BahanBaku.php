<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahanbakus';
    protected $fillable = [
        'nama_bahan_baku',
        'harga_bahan_baku',
        'gambar_bahan_baku',
        'jumlah_bahan_baku',
    ];

    public function detailTransaksiPembelian()
    {
        return $this->hasMany(detailTransaksiPembelian::class, 'id_bahan_baku');
    }
}
