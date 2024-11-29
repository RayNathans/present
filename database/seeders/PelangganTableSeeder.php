<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy untuk tabel pelanggans
        $pelanggans = [
            [
                'nama_pelanggan' => 'Alice',
                'noWA' => '081234567890',
                'progressTransaksi' => 0, // Awalnya 0, akan diperbarui dengan transaksi
                'id_member' => 1, // Mengacu pada id_member yang ada
            ],
            [
                'nama_pelanggan' => 'Bob',
                'noWA' => '081234567891',
                'progressTransaksi' => 0,
                'id_member' => 2,
            ],
            [
                'nama_pelanggan' => 'Charlie',
                'noWA' => '081234567892',
                'progressTransaksi' => 0,
                'id_member' => 1,
            ],
            // Tambahkan lebih banyak data sesuai kebutuhan
        ];

        // Menambahkan data ke tabel pelanggans
        foreach ($pelanggans as $pelanggan) {
            DB::table('pelanggans')->insert($pelanggan);
        }
    }
}
