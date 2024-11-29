<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    // use HasFactory;
    protected $table = 'transaksi_penjualans';
    protected $fillable = [
        'id_user',
        'id_pelanggan',
        'total_harga',
        'nomor_meja',
        'status',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    public function calculateTotalHarga()
    {
        $detailTransaksi = $this->detailTransaksiPenjualans; // Ambil detail transaksi
        $totalHarga = 0;

        foreach ($detailTransaksi as $detail) {
            $totalHarga += $detail->total_harga_per_menu;
        }

        $this->total_harga = $totalHarga;
        $this->save();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function detailTransaksiPenjualans()
    {
        return $this->hasMany(DetailTransaksiPenjualan::class, 'id_transaksi_penjualan');
    }
}
