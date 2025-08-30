<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nisn' => $this->faker->unique()->numerify('DUMMY####'),
            'kelas' => $this->faker->randomElement(['XI.1', 'XI.2', 'XI.3', 'XI.4']),
            'alamat' => $this->faker->address(),
            'telepon' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password123'), // biar gampang login
            'jenis' => 'siswa',
            'status' => 'disetujui',
            'akun' => 'aktif',
            'nip' => null,
            'remember_token' => Str::random(10),
        ];
    }
}
