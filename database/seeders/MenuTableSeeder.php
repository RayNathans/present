<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar menu yang akan ditambahkan
        $menus = [
            [
                'nama_menu' => 'Nasi Goreng',
                'harga_menu' => 15000,
                'gambar_menu' => "Nasgor.png",
            ],
            [
                'nama_menu' => 'Mie Ayam',
                'harga_menu' => 12000,
                'gambar_menu' => 'telur.png',
            ],
            [
                'nama_menu' => 'Bakso Kuah',
                'harga_menu' => 20000,
                'gambar_menu' => 'bakso-kuah.jpg',
            ],
            [
                'nama_menu' => 'Mie Pangsit',
                'harga_menu' => 13000,
                'gambar_menu' => 'mie-pangsit.jpeg',
            ],
            [
                'nama_menu' => 'Ayam Goreng',
                'harga_menu' => 25000,
                'gambar_menu' => 'ayam-goreng.jpeg',
            ],
            [
                'nama_menu' => 'Kwetiaw Goreng',
                'harga_menu' => 16000,
                'gambar_menu' => 'images/user-36-05.jpg',
            ],
            [
                'nama_menu' => 'Mie Goreng',
                'harga_menu' => 14000,
                'gambar_menu' => 'images/mie-goreng',
            ],
            [
                'nama_menu' => 'Telur Balado',
                'harga_menu' => 12000,
                'gambar_menu' => 'images/user-36-05.jpg',
            ],
            [
                'nama_menu' => 'Terong Goreng',
                'harga_menu' => 11000,
                'gambar_menu' => 'images/user-36-05.jpg',
            ],
            [
                'nama_menu' => 'Sate Ayam',
                'harga_menu' => 30000,
                'gambar_menu' => 'images/user-36-05.jpg',
            ],
        ];

        // Menambahkan data dummy ke dalam tabel menus
        foreach ($menus as $menu) {
            DB::table('menus')->insert($menu);
        }
    }
}
