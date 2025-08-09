<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Seeder untuk admin
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'nama' => 'admin',
                'alamat' => 'xxxx',
                'telepon' => '12345',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin@123'),
                'jenis' => 'admin',
                'status' => 'diterima'
            ]);
        }

        
    }
}
