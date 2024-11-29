<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar nama pengguna dan password yang tidak di-hash untuk referensi
        $names = [
            ['name' => 'Alice', 'password' => 'password123'],
            ['name' => 'Bob', 'password' => 'password123'],
            ['name' => 'Charlie', 'password' => 'password123'],
            ['name' => 'David', 'password' => 'password123'],
            ['name' => 'Eva', 'password' => 'password123'],
            ['name' => 'Frank', 'password' => 'password123'],
            ['name' => 'Grace', 'password' => 'password123'],
            ['name' => 'Hannah', 'password' => 'password123'],
            ['name' => 'Ian', 'password' => 'password123'],
            ['name' => 'Julia', 'password' => 'password123'],
        ];

        // Menambahkan data dummy untuk tabel users
        foreach ($names as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => strtolower($user['name']) . '@example.com',
                'password' => bcrypt($user['password']), // Hash password sebelum menyimpan
                'id_role' => rand(2, 3), // Menggunakan id_role antara 2 dan 3
            ]);

            // Menampilkan nama dan password asli untuk referensi
            echo "User: {$user['name']}, Password: {$user['password']}\n";
        }
    }
}
