<?php

namespace App\Http\Controllers;

use App\Models\DaerahPemilihan;
use App\Models\TahunPemilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DaerahPemilihanController extends Controller
{
    public function index($tahun_pemilihan_id)
    {
        $dataTahunPemilihan = TahunPemilihan::with(['daerah_pemilihan'])->where('id', $tahun_pemilihan_id)->first();

        // jika data tidak ditemukan
        if (!$dataTahunPemilihan) {
            return redirect(route('dashboard'));
        }

        return view('dashboard.daerah-pemilihan.index', [
            'title'   => 'Daerah Pemilihan',
            'nav_active' => 'menu-tahun-pemilihan',
            'dataTahun' => $dataTahunPemilihan
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // PROSES VALIDASI MULAI
        // membuat validasi data yang di input user
        $validatedData = Validator::make($request->all(), [
            'tahun_pemilihan_id' => 'required',
            'nama_daerah' => 'required',
        ], [
            'tahun_pemilihan_id.required' => 'Tahun Pemilihan tidak boleh kosong!',
            'nama_daerah.required' => 'Nama Daerah tidak boleh kosong!',
        ]);

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'Daerah Pemilihan gagal ditambahkan!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            DaerahPemilihan::create([
                'tahun_pemilihan_id' => $request->tahun_pemilihan_id,
                'nama_daerah' => $request->nama_daerah,
                'keterangan' => $request->keterangan,
            ]);
            
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // redirect
            Alert::error('Gagal', 'Daerah Pemilihan gagal ditambahkan!');
            // return redirect()->back()->with('failed', '<strong>Data Daerah Pemilihan Gagal Disimpan</strong> : ' . $th->getMessage());
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI

        // redirect
        Alert::success('Berhasil', 'Daerah Pemilihan berhasil ditambahkan!');
        return redirect()->route('daerah-pemilihan.index', $request->tahun_pemilihan_id);
    }

    public function destroy(string $id)
    {
        try {
            // menghapus sebuah data pada database
            $dataDaerahPemilihan = DaerahPemilihan::where('id', $id)->first();
            $dataDaerahPemilihan->delete();
        } catch (\Throwable $th) {
            // redirect
            Alert::error('Gagal', 'Daerah Pemilihan gagal dihapus!');
            return redirect()->back();
        }

        // redirect
        Alert::success('Berhasil', 'Daerah Pemilihan berhasil dihapus!');
        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        // ambil data berdasarkan id
        $dataDaerahPemilihan = DaerahPemilihan::where('id', $id)->first();

        // PROSES VALIDASI MULAI
        // membuat aturan validasi
        $validatedData = Validator::make($request->all(), [
            'nama_daerah' => 'required',
        ], [
            'nama_daerah.required' => 'Nama Daerah tidak boleh kosong!',
        ]);

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'Daerah Pemilihan gagal diubah!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            DaerahPemilihan::where('id', $id)->update([
                'nama_daerah' => $request->nama_daerah,
                'keterangan' => $request->keterangan,
            ]);
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // redirect
            Alert::error('Gagal', 'Daerah Pemilihan gagal diubah!');
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI
        
        // pindah ke halaman index
        Alert::success('Berhasil', 'Daerah Pemilihan berhasil diubah!');
        return redirect(route('daerah-pemilihan.index', $dataDaerahPemilihan->tahun_pemilihan_id));
    }
}
