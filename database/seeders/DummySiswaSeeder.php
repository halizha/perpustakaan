<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DummySiswaSeeder extends Seeder
{
    public function run(): void
    {
        // generate 20 akun siswa dummy
        User::factory()->count(5)->create();
    }
}
