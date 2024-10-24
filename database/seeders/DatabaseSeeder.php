<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        $this->lembaga_legislatif();
    }

    private function lembaga_legislatif()
    {
        \App\Models\LembagaLegislatif::factory()->create([
            'nama_lembaga' => 'Dewan Perwakilan Rakyat Daerah (DPRD) Provinsi Sumatera Utara',
        ]);
    }
}
