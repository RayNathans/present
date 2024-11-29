<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Pastikan mengimpor Carbon untuk mengatur tanggal

class TransaksiPembelianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID pengguna yang ada
        $users = DB::table('users')->pluck('id')->toArray();

        // Buat data dummy untuk tabel transaksiPembelian
        for ($i = 1; $i <= 10; $i++) {
            DB::table('transaksiPembelians')->insert([
                'id_user' => $users[array_rand($users)], // Mengambil random id_user
                'total_harga' => rand(100000, 300000), // Total harga antara 100.000 hingga 300.000
                'tanggal_transaksi' => Carbon::now()->subDays(rand(0, 30)), // Tanggal transaksi dalam 30 hari terakhir
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
