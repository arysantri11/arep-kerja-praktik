<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CalegFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'partai_id' => 1,
            'daerah_pemilihan_id' => 1,
            'nama_lengkap' => '-',
            'jenis_kelamin' => fake()->randomElement(['l', 'p']),
            'tempat_lahir' => '-',
            'tanggal_lahir' => '1988/12/15',
            'pekerjaan' => '-',
            'status' => '-',
            'foto' => '',
            'alamat' => '-',
        ];
    }
}
