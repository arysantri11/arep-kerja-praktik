<?php

namespace App\Http\Controllers;

use App\Models\Caleg;
use App\Models\DaerahPemilihan;
use App\Models\LembagaLegislatif;
use App\Models\PartaiPolitik;
use App\Models\TahunPemilihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CalegController extends Controller
{
    public function pilih_lembaga()
    {
        return view('dashboard.caleg.pilih-lembaga', [
            'title'   => 'Pendaftaran Caleg',
            'nav_active' => 'menu-caleg',
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

        return view('dashboard.caleg.pilih-tahun', [
            'title'   => 'Pendaftaran Caleg',
            'nav_active' => 'menu-caleg',
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

        return view('dashboard.caleg.pilih-dapil', [
            'title'   => 'Pendaftaran Caleg',
            'nav_active' => 'menu-caleg',
            'dataTahun' => $dataTahunPemilihan
        ]);
    }

    public function index($dapil_id)
    {
        
        $dataDaerahPemilihan = DaerahPemilihan::with(['tahun_pemilihan', 'caleg'])->first();

        // jika data tidak ditemukan
        if (!$dataDaerahPemilihan) {
            return redirect(route('dashboard'));
        }

        // Get Data User Login
        $dataPartai = PartaiPolitik::where('user_id', auth()->user()->id)->first();
        $dataCaleg = $dataDaerahPemilihan->caleg->where('partai_id', $dataPartai->id);

        return view('dashboard.caleg.index', [
            'title'   => 'Pendaftaran Caleg',
            'nav_active' => 'menu-caleg',
            'dataDapil' => $dataDaerahPemilihan,
            'dataCaleg' => $dataCaleg,
            'dataPartai' => $dataPartai,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // PROSES VALIDASI MULAI
        // membuat validasi data yang di input user
        $validatedData = Validator::make($request->all(), [
            'partai_id' => 'required',
            'daerah_pemilihan_id' => 'required',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
        ], [
            'nama_lengkap.required' => 'Nama tidak boleh kosong',
            'jenis_kelamin.required' => 'Pilih jenis kelamin terlebih dahulu',
            'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
            'tanggal_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
        ]);

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'Caleg gagal ditambahkan!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // PROSES UPLOAD FOTO MULAI
        $namaFile = ''; // default nama file

        // logic = jika file di upload
        if($request->foto) {
            $fileUpload = $request->foto;
            $namaFile = $this->randomFileName($fileUpload->getClientOriginalExtension());

            // cek file di dalam local storage
            while (File::exists($this->calegFoto_pathFile($namaFile))) {
                // ganti nama file
                $namaFile = $this->randomFileName($fileUpload->getClientOriginalExtension());
            }
    
            // simpan file ke dalam local storage
            $fileUpload->move($this->calegFoto_pathFolder(), $namaFile);
        }
        // PROSES UPLOAD FOTO SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            Caleg::create([
                'partai_id' => $request->partai_id,
                'daerah_pemilihan_id' => $request->daerah_pemilihan_id,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'pekerjaan' => $request->pekerjaan,
                'status' => $request->status,
                'alamat' => $request->alamat,
                'foto' => $namaFile,
            ]);
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // PROSES HAPUS FILE MULAI
            // jika file diupload
            if($request->profile) {
                // jika file ditemukan
                if (File::exists($this->calegFoto_pathFile($namaFile))) {
                    File::delete($this->calegFoto_pathFile($namaFile)); // hapus file
                }
            }
            // PROSES HAPUS FILE SELESAI

            // redirect
            Alert::error('Gagal', 'Caleg gagal ditambahkan!');
            // return redirect()->back()->with('failed', '<strong>Data Caleg Gagal Disimpan</strong> : ' . $th->getMessage());
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI

        // redirect
        Alert::success('Berhasil', 'Caleg berhasil ditambahkan!');
        return redirect()->route('caleg.index', $request->daerah_pemilihan_id);
    }

    public function destroy(string $id)
    {
        try {
            // menghapus sebuah data pada database
            $dataCaleg = Caleg::where('id', $id)->first();
            $fotoCaleg = $dataCaleg->foto;
            $dataCaleg->delete();

            // PROSES HAPUS FILE MULAI
            // jika data tidak kosong
            if ($fotoCaleg !== '') {
                // jika file ditemukan
                if (File::exists($this->calegFoto_pathFile($fotoCaleg))) {
                    File::delete($this->calegFoto_pathFile($fotoCaleg)); // hapus file
                }
            }
            // PROSES HAPUS FILE SELESAI
        } catch (\Throwable $th) {
            // redirect
            Alert::error('Gagal', 'Caleg gagal dihapus!');
            return redirect()->back();
        }

        // redirect
        Alert::success('Berhasil', 'Caleg berhasil dihapus!');
        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        // ambil data berdasarkan id
        $dataCaleg = Caleg::where('id', $id)->first();
        $foto_old = $dataCaleg->foto; // foto lama

        // PROSES VALIDASI MULAI
        // membuat aturan validasi
        $validatedData = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
        ], [
            'nama_lengkap.required' => 'Nama tidak boleh kosong',
            'jenis_kelamin.required' => 'Pilih jenis kelamin terlebih dahulu',
            'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
            'tanggal_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
        ]);

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'Caleg gagal diubah!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // PROSES UPLOAD FILE BARU MULAI
        $namaFile_new = '';

        // jika file di upload
        if($request->foto) {
            $fileUpload = $request->foto;

            // buat nama file baru
            $namaFile_new = $this->randomFileName($fileUpload->getClientOriginalExtension());

            // cek file di dalam local storage
            while (File::exists($this->calegFoto_pathFile($namaFile_new))) {
                // ganti nama file
                $namaFile_new = $this->randomFileName($fileUpload->getClientOriginalExtension());
            }
            
            // simpan file ke dalam local storage
            $fileUpload->move($this->calegFoto_pathFolder(), $namaFile_new);
        }
        // PROSES UPLOAD FILE BARU SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            Caleg::where('id', $id)->update([
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'pekerjaan' => $request->pekerjaan,
                'status' => $request->status,
                'alamat' => $request->alamat,
                'foto' => ($request->foto)? $namaFile_new : $foto_old,
            ]);

            // PROSES HAPUS FILE LAMA MULAI
            if ($request->foto && ($foto_old !== '')) {
                // jika file ditemukan
                if (File::exists($this->calegFoto_pathFile($foto_old))) {
                    File::delete($this->calegFoto_pathFile($foto_old)); // hapus file
                }
            }
            // PROSES HAPUS FILE LAMA SELESAI
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // PROSES HAPUS FILE BARU MULAI
            if($request->foto) {
                // jika file ditemukan
                if (File::exists($this->calegFoto_pathFile($namaFile_new))) {
                    File::delete($this->calegFoto_pathFile($namaFile_new)); // hapus file
                }
            }
            // PROSES HAPUS FILE BARU SELESAI

            // redirect
            Alert::error('Gagal', 'Caleg gagal diubah!');
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI
        
        // pindah ke halaman index
        Alert::success('Berhasil', 'Caleg berhasil diubah!');
        return redirect(route('caleg.index', $dataCaleg->daerah_pemilihan_id));
    }
}
