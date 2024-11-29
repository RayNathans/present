<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiPenjualanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua pelanggan
        $pelanggans = DB::table('pelanggans')->pluck('id');

        foreach ($pelanggans as $pelanggan) {
            $totalHargaTransaksi = 0; // Inisialisasi total harga transaksi
            
            // Simulasi beberapa transaksi penjualan
            for ($i = 0; $i < rand(1, 5); $i++) { // Random antara 1 hingga 5 transaksi
                // Buat transaksi penjualan
                $transaksi = DB::table('transaksi_penjualans')->insertGetId([
                    'id_user' => rand(1, 10), // Asumsi ada 10 user
                    'id_pelanggan' => $pelanggan,
                    'total_harga' => 0, // Akan diperbarui nanti
                    'tanggal_transaksi' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'nomor_meja' => rand(1, 5),
                ]);

                $detailHargaTransaksi = 0; // Inisialisasi untuk detail harga transaksi
                
                // Buat beberapa detail transaksi untuk setiap transaksi
                for ($j = 0; $j < rand(1, 5); $j++) { // Random antara 1 hingga 5 detail
                    $menu = DB::table('menus')->inRandomOrder()->first(); // Ambil menu acak
                    $jumlahMenu = rand(1, 5); // Jumlah menu yang dibeli
                    $nomor_meja = rand(1, 5); // Jumlah menu yang dibeli
                    $totalHargaPerMenu = $menu->harga_menu * $jumlahMenu;

                    // Simpan detail transaksi penjualan
                    DB::table('detailTransaksiPenjualans')->insert([
                        'id_menu' => $menu->id,
                        'id_transaksi_penjualan' => $transaksi,
                        'jumlah_menu' => $jumlahMenu,
                        'total_harga_per_menu' => $totalHargaPerMenu,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Akumulasi detail harga transaksi
                    $detailHargaTransaksi += $totalHargaPerMenu;
                }

                // Update total_harga di transaksiPenjualans
                DB::table('transaksi_penjualans')->where('id', $transaksi)->update([
                    'total_harga' => $detailHargaTransaksi,
                    'updated_at' => now(),
                ]);

                // Akumulasi total harga transaksi untuk pelanggan
                $totalHargaTransaksi += $detailHargaTransaksi;
            }

            // Update progressTransaksi di tabel pelanggan
            DB::table('pelanggans')->where('id', $pelanggan)->update([
                'progressTransaksi' => DB::raw('progressTransaksi + ' . $totalHargaTransaksi),
                'updated_at' => now(),
            ]);

            // Update nama_member jika progressTransaksi melebihi batas_bawah_member
            $this->updateMemberTier($pelanggan);
        }
    }

    private function updateMemberTier($pelanggan)
    {
        // Ambil progressTransaksi dan id_member dari tabel pelanggan
        $pelangganData = DB::table('pelanggans')->where('id', $pelanggan)->first();
        
        // Ambil data batas bawah member dari tabel members
        $member = DB::table('members')->where('id', $pelangganData->id_member)->first();
        
        if ( $member->batas_bawah_member > $pelangganData->progressTransaksi) {
            // Ganti nama_member berdasarkan tier yang sesuai
            // Asumsi ada logika untuk menentukan tier baru
            $newTier = 'Non Member'; // Ganti dengan logika yang sesuai

            // Update nama_member
            DB::table('members')->where('id', $pelangganData->id_member)->update([
                'nama_member' => $newTier,
                'updated_at' => now(),
            ]);
        }
    }
}