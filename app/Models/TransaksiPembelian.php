<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransaksiPembelian extends Model
{
    // use HasFactory;
    protected $table = 'transaksipembelians';
    protected $fillable = ['id_user', 'total_harga', 'tanggal_transaksi'];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailTransaksiPembelian()
    {
        return $this->hasMany(DetailTransaksiPembelian::class, 'id_transaksi_beli');
    }
}