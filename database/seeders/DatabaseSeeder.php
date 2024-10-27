<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DaerahPemilihan;
use App\Models\LembagaLegislatif;
use App\Models\PartaiPolitik;
use App\Models\TahunPemilihan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->users();
        $this->lembaga_legislatif();
        $this->partai_politik();
        $this->caleg();
    }

    private function users()
    {
        \App\Models\User::factory()->create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'nama' => 'Admin KPU Sumatera Utara',
            'role' => '1',
            'aktif' => 'y',
        ])->create([
            'username' => 'demokrat',
            'password' => bcrypt('demokrat'),
            'nama' => 'Demokrasi Rakyat',
            'role' => '2',
            'aktif' => 'y',
        ])->create([
            'username' => 'golkar',
            'password' => bcrypt('golkar'),
            'nama' => 'Golongan Rakyat',
            'role' => '2',
            'aktif' => 'y',
        ]);
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

    private function partai_politik()
    {
        $dataUser = User::where('role', 2)->get();

        foreach ($dataUser as $item) {
            \App\Models\PartaiPolitik::factory()->create([
                'user_id' => $item->id,
            ]);
        }
    }

    private function caleg()
    {
        $dataPartai = PartaiPolitik::all();
        $dataDapil = DaerahPemilihan::all();

        \App\Models\Caleg::factory()->create([
            'partai_id' => $dataPartai->find(1)->id,
            'daerah_pemilihan_id' => $dataDapil->find(1)->id,
            'nama_lengkap' => 'Raja Abi',
            'jenis_kelamin' => 'l',
            'tempat_lahir' => 'Medan Tuntungan',
            'tanggal_lahir' =>'1980/10/15',
            'pekerjaan' => 'wiraswasta',
            'status' => 'Belum Menikah',
            'foto' => '',
            'alamat' => 'Medan Tembung',
        ])->create([
            'partai_id' => $dataPartai->find(1)->id,
            'daerah_pemilihan_id' => $dataDapil->find(1)->id,
            'nama_lengkap' => 'Azwan Renaldi',
            'jenis_kelamin' => 'l',
            'tempat_lahir' => 'Serdang Bedagai',
            'tanggal_lahir' =>'1997/12/12',
            'pekerjaan' => 'Petani',
            'status' => 'Sudah Menikah',
            'foto' => '',
            'alamat' => 'Medan Johor',
        ])->create([
            'partai_id' => $dataPartai->find(2)->id,
            'daerah_pemilihan_id' => $dataDapil->find(2)->id,
            'nama_lengkap' => 'Andra Sadefa',
            'jenis_kelamin' => 'l',
            'tempat_lahir' => 'Batu Bara',
            'tanggal_lahir' =>'1988/10/10',
            'pekerjaan' => 'Wiraswasta',
            'status' => 'Sudah Menikah',
            'foto' => '',
            'alamat' => 'Medan Tuntungan',
        ]);
    }
}
