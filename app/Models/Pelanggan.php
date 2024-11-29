<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = ['nama_pelanggan', 'noWA', 'progressTransaksi', 'id_member'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function updateProgressTransaksi($amount)
    {
        $this->progressTransaksi += $amount;
        $this->save();
        
        // Perbarui nama_member berdasarkan progressTransaksi
        $this->checkMemberTier();
    }

    private function checkMemberTier()
    {
        // Ambil batas bawah dari member
        $member = Member::find($this->id_member);
        if ($this->progressTransaksi > $member->batas_bawah_member) {
            // Ganti nama_member jika memenuhi syarat
            $this->id_member = $member->next_tier_id; // Misalkan Anda menyimpan tier selanjutnya di database
            $this->save();
        }
    }

    public function transaksiPenjualans()
    {
        return $this->hasMany(TransaksiPenjualan::class, 'id_transaksi_penjualan'); // Menghubungkan kembali dengan model TransaksiPenjualan
    }
}
