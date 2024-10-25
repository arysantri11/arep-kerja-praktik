<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\LembagaLegislatif;
use App\Models\TahunPemilihan;
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

        // Get Data Lembaga
        $dataLembaga = LembagaLegislatif::all()->first();

        // Seeder Tahun Pemilihan
        $this->tahun_pemilihan($dataLembaga->id);
    }

    private function tahun_pemilihan($lembaga_legislatif_id)
    {
        \App\Models\TahunPemilihan::factory()->create([
            'lembaga_legislatif_id' => $lembaga_legislatif_id,
            'tahun' => '2022',
            'tanggal' => '2022/11/12',
            'keterangan' => '',
        ])->create([
            'lembaga_legislatif_id' => $lembaga_legislatif_id,
            'tahun' => '2023',
            'tanggal' => '2023/12/28',
            'keterangan' => '',
        ])->create([
            'lembaga_legislatif_id' => $lembaga_legislatif_id,
            'tahun' => '2024',
            'tanggal' => '2024/10/17',
            'keterangan' => '',
        ]);

        // Get Data Lembaga
        $dataTahunPemilihan = TahunPemilihan::all()->first();

        // Seeder Tahun Pemilihan
        $this->daerah_pemilihan($dataTahunPemilihan->id);
    }

    private function daerah_pemilihan($tahun_pemilihan_id)
    {
        \App\Models\DaerahPemilihan::factory()->create([
            'tahun_pemilihan_id' => $tahun_pemilihan_id,
            'nama_daerah' => 'Dapil I',
            'keterangan' => 'Asahan, Batu Bara',
        ])->create([
            'tahun_pemilihan_id' => $tahun_pemilihan_id,
            'nama_daerah' => 'Dapil II',
            'keterangan' => 'Labuhan Batu Utara, Labuhan Batu, Labuhan Batu Selatan',
        ])->create([
            'tahun_pemilihan_id' => $tahun_pemilihan_id,
            'nama_daerah' => 'Dapil III',
            'keterangan' => 'Deli Serdang, Serdang Bedagai',
        ]);
    }
}
