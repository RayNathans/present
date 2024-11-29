<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TLaporanransaksiPenjualan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_penjualans';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksiPenjualan::class, 'id_transaksi_penjualan');
    }
}
