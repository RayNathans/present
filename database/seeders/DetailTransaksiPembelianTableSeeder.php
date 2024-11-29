<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailTransaksiPembelianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data dari tabel bahanbakus
        $bahanBakus = DB::table('bahanbakus')->get();

        // Ambil semua transaksi beli
        $transaksiBeli = DB::table('transaksiPembelians')->pluck('id');

        foreach ($transaksiBeli as $transaksi) {
            $totalHargaTransaksi = 0; // Inisialisasi total harga transaksi
            
            // Buat beberapa detail pembelian untuk setiap transaksi
            for ($j = 0; $j < rand(1, 5); $j++) { // Random antara 1 hingga 5 detail
                // Pilih bahan baku acak
                $bahanBaku = $bahanBakus->random();

                // Hitung total harga per bahan baku
                $jumlah = rand(1, 10);
                $totalHargaPerBahanBaku = $bahanBaku->harga_bahan_baku * $jumlah; // Menggunakan atribut yang benar

                // Simpan detail pembelian
                DB::table('detailPembelians')->insert([
                    'id_bahan_baku' => $bahanBaku->id,
                    'jumlah_per_bahan_baku' => $jumlah,
                    'total_harga_per_bahan_baku' => $totalHargaPerBahanBaku,
                    'id_transaksi_beli' => $transaksi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update total harga transaksi
                $totalHargaTransaksi += $totalHargaPerBahanBaku;
            }

            // Update total_harga di transaksiPembelians
            DB::table('transaksiPembelians')->where('id', $transaksi)->update([
                'total_harga' => $totalHargaTransaksi,
                'updated_at' => now(),
            ]);
        }
    }
}
