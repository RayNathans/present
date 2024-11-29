<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';

    protected $fillable = [
        'nama_member',
        'diskon_member',
        'batas_atas_member',
        'batas_bawah_member',
    ];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'id_pelanggan');
    }
}
