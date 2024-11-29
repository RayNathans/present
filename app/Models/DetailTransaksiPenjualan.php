<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiPenjualan extends Model
{
    protected $table = 'detailTransaksiPenjualans';
    protected $fillable = ['id_transaksi_penjualan', 'id_menu', 'jumlah_menu', 'total_harga_per_menu'];

    public function transaksiPenjualan()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'id_transaksi_penjualan');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($detail) {
            $detail->total_harga_per_menu = $detail->jumlah_menu * $detail->menu->harga_menu;
        });

        static::updating(function ($detail) {
            $detail->total_harga_per_menu = $detail->jumlah_menu * $detail->menu->harga_menu;
        });
    }
}
