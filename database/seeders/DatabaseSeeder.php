<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            DashboardTableSeeder::class,
            RoleTableSeeder::class,
            UserTableSeeder::class,
            MenuTableSeeder::class,
            BahanBakuTableSeeder::class,
            MemberTableSeeder::class,
            PelangganTableSeeder::class,
            TransaksiPenjualanTableSeeder::class,
            TransaksiPembelianTableSeeder::class,
            DetailTransaksiPembelianTableSeeder::class
        ]);
    }
}
