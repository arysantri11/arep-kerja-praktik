<?php

namespace App\Http\Controllers;

use App\Models\Caleg;
use App\Models\DaerahPemilihan;
use App\Models\LembagaLegislatif;
use App\Models\PartaiPolitik;
use App\Models\TahunPemilihan;
use App\Models\User;
use Illuminate\Http\Request;

class DaftarCalegController extends Controller
{
    public function pilih_lembaga()
    {
        return view('dashboard.daftar-caleg.pilih-lembaga', [
            'title'   => 'Daftar Caleg',
            'nav_active' => 'menu-daftar-daftar-caleg',
            'dataLembagaLegislatif' => LembagaLegislatif::all()
        ]);
    }

    public function pilih_tahun($lembaga_id)
    {
        $dataLembaga = LembagaLegislatif::with(['tahun_pemilihan'])->where('id', $lembaga_id)->first();

        // jika data tidak ditemukan
        if (!$dataLembaga) {
            return redirect(route('dashboard'));
        }

        return view('dashboard.daftar-caleg.pilih-tahun', [
            'title'   => 'Daftar Caleg',
            'nav_active' => 'menu-daftar-caleg',
            'dataLembaga' => $dataLembaga,
        ]);
    }

    public function pilih_dapil($tahun_id)
    {
        $dataTahunPemilihan = TahunPemilihan::with(['daerah_pemilihan'])->where('id', $tahun_id)->first();

        // jika data tidak ditemukan
        if (!$dataTahunPemilihan) {
            return redirect(route('dashboard'));
        }

        return view('dashboard.daftar-caleg.pilih-dapil', [
            'title'   => 'Daftar Caleg',
            'nav_active' => 'menu-daftar-caleg',
            'dataTahun' => $dataTahunPemilihan
        ]);
    }

    public function index($dapil_id)
    {
        $dataDaerahPemilihan = DaerahPemilihan::with(['tahun_pemilihan'])->where('id', $dapil_id)->first();

        // jika data tidak ditemukan
        if (!$dataDaerahPemilihan) {
            return redirect(route('dashboard'));
        }

        $dataCaleg = Caleg::with(['partai_politik', 'daerah_pemilihan'])->where('daerah_pemilihan_id', $dapil_id)->get();

        return view('dashboard.daftar-caleg.index', [
            'title'   => 'Daftar Caleg',
            'nav_active' => 'menu-daftar-caleg',
            'dataDapil' => $dataDaerahPemilihan,
            'dataCaleg' => $dataCaleg,
        ]);
    }

    public function cetak($dapil_id)
    {
        $dataDaerahPemilihan = DaerahPemilihan::with(['tahun_pemilihan'])->where('id', $dapil_id)->first();

        // jika data tidak ditemukan
        if (!$dataDaerahPemilihan) {
            return redirect(route('dashboard'));
        }

        // Data Partai
        $dataPartai = PartaiPolitik::with(['caleg', 'users'])->get();

        // mengumpulkan data yang akan dicetak
        $dataCetak = collect();

        foreach ($dataPartai as $itemPartai) {
            $filterCaleg = $itemPartai->caleg->where('daerah_pemilihan_id', $dapil_id);

            $dataCetak->add([
                'dataPartai' => $itemPartai,
                'dataUser' => $itemPartai->users,
                'dataCaleg' => $filterCaleg
            ]);
        }

        return view('dashboard.daftar-caleg.cetak', [
            'title'   => 'Cetak Daftar Caleg',
            'nav_active' => 'menu-daftar-caleg',
            'dataDapil' => $dataDaerahPemilihan,
            'dataCetak' => $dataCetak,
        ]);
    }
}
