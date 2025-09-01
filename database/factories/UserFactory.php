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
            'nisn' => null,
            'kelas' => null,
            'alamat' => $this->faker->address(),
            'telepon' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password123'), // biar gampang login
            'jenis' => 'guru',
            'status' => 'disetujui',
            'akun' => 'aktif',
            'nip' => $this->faker->unique()->numerify('DUMMY####'),
            'remember_token' => Str::random(10),
        ];
    }
}
