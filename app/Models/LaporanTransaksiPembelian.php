<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTransaksiPembelian extends Model
{
    use HasFactory;

    protected $table = 'transaksipembelians';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailTransaksiPembelian()
    {
        return $this->hasMany(DetailTransaksiPembelian::class, 'id_transaksi_beli');
    }
}

