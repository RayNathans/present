<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiPembelian extends Model
{
    protected $table = 'detailPembelians';
    protected $fillable = ['id_transaksi_beli', 'id_bahan_baku', 'jumlah_per_bahan_baku', 'total_harga_per_bahan_baku'];


    public function transaksiPembelian()
    {
        return $this->belongsTo(TransaksiPembelian::class, 'id_transaksi_beli');
    }

    public function bahanbaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku');
    }
}
