<?php

namespace App\Http\Controllers;

use App\Models\LembagaLegislatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LembagaLegislatifController extends Controller
{
    public function index()
    {
        return view('dashboard.lembaga-legislatif.index', [
            'title'   => 'Lembaga Legislatif',
            'nav_active' => 'menu-lembaga-legislatif',
            'dataLembagaLegislatif' => LembagaLegislatif::all()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // PROSES VALIDASI MULAI
        // membuat validasi data yang di input user
        $validatedData = Validator::make($request->all(), [
            'nama_lembaga' => 'required|unique:lembaga_legislatif',
        ], [
            'nama_lembaga.required' => 'Nama Lembaga tidak boleh kosong',
            'nama_lembaga.unique' => 'Nama Lembaga telah digunakan',
        ]);

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'Lembaga Legisatif gagal ditambahkan!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            LembagaLegislatif::create([
                'nama_lembaga' => $request->nama_lembaga,
            ]);
            
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // redirect
            Alert::error('Gagal', 'Lembaga Legisatif gagal ditambahkan!');
            // return redirect()->back()->with('failed', '<strong>Data Lembaga Legisatif Gagal Disimpan</strong> : ' . $th->getMessage());
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI

        // redirect
        Alert::success('Berhasil', 'Lembaga Legisatif berhasil ditambahkan!');
        return redirect()->route('lembaga-legislatif.index');
    }

    public function update(Request $request, string $id)
    {
        // ambil data berdasarkan id
        $dataLembagaLegislatif = LembagaLegislatif::where('id', $id)->first();

        // PROSES VALIDASI MULAI
        // membuat aturan validasi
        $validatedData = Validator::make($request->all(), [
            'nama_lembaga' => 'required',
        ], [
            'nama_lembaga.required' => 'Nama Lembaga tidak boleh kosong',
        ]);

        // jika nama lembaga di edit
        if ($request->nama_lembaga !== $dataLembagaLegislatif->nama_lembaga) {
            // update aturan validasi
            $validatedData = Validator::make($request->all(),  [
                'nama_lembaga' => 'required|unique:lembaga_legislatif',
            ], [
                'nama_lembaga.required' => 'Nama Lembaga tidak boleh kosong',
                'nama_lembaga.unique' => 'Nama Lembaga telah digunakan',
            ]);
        }

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'Lembaga Legisatif gagal diubah!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            LembagaLegislatif::where('id', $id)->update([
                'nama_lembaga' => $request->nama_lembaga,
            ]);
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // redirect
            Alert::error('Gagal', 'Lembaga Legisatif gagal diubah!');
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI
        
        // pindah ke halaman index
        Alert::success('Berhasil', 'Lembaga Legisatif berhasil diubah!');
        return redirect(route('lembaga-legislatif.index'));
    }

    public function destroy(string $id)
    {
        try {
            // menghapus sebuah data pada database
            $dataLembagaLegislatif = LembagaLegislatif::where('id', $id)->first();
            $dataLembagaLegislatif->delete();
        } catch (\Throwable $th) {
            // redirect
            Alert::error('Gagal', 'Lembaga Legislatif gagal dihapus!');
            return redirect()->back();
        }

        // redirect
        Alert::success('Berhasil', 'Lembaga Legislatif berhasil dihapus!');
        return redirect()->back();
    }
}
