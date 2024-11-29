<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model yang dibentuk dari plural
    protected $table = 'menus';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_menu',
        'nama_menu',
        'harga_menu',
        'gambar_menu',
    ];

    public function detailTransaksiPenjualan()
    {
        return $this->hasMany(DetailTransaksiPenjualan::class, 'id_menu');
    }

    // public function getGambarMenuAttribute($value)
    // {
    //     return $value ? asset('public/' . $value) : asset('placeholder.png');
    // }
}
