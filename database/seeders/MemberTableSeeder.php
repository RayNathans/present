<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar member
        $members = [
            [
                'nama_member' => 'Non Member',
                'diskon_member' => 0.00,
                'batas_atas_member' => 0, // Sesuaikan jika ada batasan
                'batas_bawah_member' => 0, // Sesuaikan jika ada batasan
            ],
            [
                'nama_member' => 'Standard',
                'diskon_member' => 0.05,
                'batas_atas_member' => 250000, // Sesuaikan jika ada batasan
                'batas_bawah_member' => 1, // Sesuaikan jika ada batasan
            ],
            [
                'nama_member' => 'VIP',
                'diskon_member' => 0.10,
                'batas_atas_member' => 500000, // Sesuaikan jika ada batasan
                'batas_bawah_member' => 250000, // Sesuaikan jika ada batasan
            ],
            [
                'nama_member' => 'Prioritas',
                'diskon_member' => 0.15,
                'batas_atas_member' => 250000, // Sesuaikan jika ada batasan
                'batas_bawah_member' => 500000, // Sesuaikan jika ada batasan
            ],
        ];

        // Menambahkan data dummy ke tabel members
        foreach ($members as $member) {
            DB::table('members')->insert($member);
        }
    }
}
