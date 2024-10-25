<?php

namespace App\Http\Controllers;

use App\Models\LembagaLegislatif;
use App\Models\TahunPemilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TahunPemilihanController extends Controller
{
    public function index()
    {
        return view('dashboard.tahun-pemilihan.index', [
            'title'   => 'Tahun Pemilihan',
            'nav_active' => 'menu-tahun-pemilihan',
            'dataTahunPemilihan' => TahunPemilihan::with(['lembaga_legislatif'])->get()->sortByDesc('tahun'),
            'dataLembaga' => LembagaLegislatif::all()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // PROSES VALIDASI MULAI
        // membuat validasi data yang di input user
        $validatedData = Validator::make($request->all(), [
            'lembaga_legislatif_id' => 'required',
            'tahun' => 'required',
            'tanggal' => 'required',
        ], [
            'lembaga_legislatif_id.required' => 'Pilih Lembaga terlebih dahulu!',
            'tahun.required' => 'Tahun tidak boleh kosong!',
            'tanggal.required' => 'Tanggal tidak boleh kosong!',
        ]);

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'Tahun Pemilihan gagal ditambahkan!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            TahunPemilihan::create([
                'lembaga_legislatif_id' => $request->lembaga_legislatif_id,
                'tahun' => $request->tahun,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);
            
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // redirect
            Alert::error('Gagal', 'Tahun Pemilihan gagal ditambahkan!');
            // return redirect()->back()->with('failed', '<strong>Data Tahun Pemilihan Gagal Disimpan</strong> : ' . $th->getMessage());
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI

        // redirect
        Alert::success('Berhasil', 'Tahun Pemilihan berhasil ditambahkan!');
        return redirect()->route('tahun-pemilihan.index');
    }

    public function destroy(string $id)
    {
        try {
            // menghapus sebuah data pada database
            $dataTahunPemilihan = TahunPemilihan::where('id', $id)->first();
            $dataTahunPemilihan->delete();
        } catch (\Throwable $th) {
            // redirect
            Alert::error('Gagal', 'Tahun Pemilihan gagal dihapus!');
            return redirect()->back();
        }

        // redirect
        Alert::success('Berhasil', 'Tahun Pemilihan berhasil dihapus!');
        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        // ambil data berdasarkan id
        $dataTahunPemilihan = TahunPemilihan::where('id', $id)->first();

        // PROSES VALIDASI MULAI
        // membuat aturan validasi
        $validatedData = Validator::make($request->all(), [
            'tahun' => 'required',
            'tanggal' => 'required',
        ], [
            'tahun.required' => 'Tahun tidak boleh kosong!',
            'tanggal.required' => 'Tanggal tidak boleh kosong!',
        ]);

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'Tahun Pemilihan gagal diubah!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            TahunPemilihan::where('id', $id)->update([
                'tahun' => $request->tahun,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // redirect
            Alert::error('Gagal', 'Tahun Pemilihan gagal diubah!');
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI
        
        // pindah ke halaman index
        Alert::success('Berhasil', 'Tahun Pemilihan berhasil diubah!');
        return redirect(route('tahun-pemilihan.index'));
    }
}
