<?php

namespace App\Http\Controllers;

use App\Models\PartaiPolitik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DataPartaiController extends Controller
{
    public function index()
    {
        $dataUser = User::where('username', 'demokrat')->first();
        $dataPartai = PartaiPolitik::where('user_id', $dataUser->id)->first();

        // jika data tidak ditemukan
        if (!$dataUser) {
            return redirect(route('dashboard'));
        }

        return view('dashboard.data-partai.index', [
            'title'   => 'Data Partai',
            'nav_active' => 'menu-data-partai',
            'dataUser' => $dataUser,
            'dataPartai' => $dataPartai,
        ]);
    }

    public function update(Request $request, string $id)
    {
        // ambil data berdasarkan id
        $dataUser = User::where('id', $id)->first();
        $profile_old = $dataUser->profile; // profile lama

        // PROSES VALIDASI MULAI
        // membuat aturan validasi
        $validatedData = Validator::make($request->all(), [
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
        ]);

        // jika password di edit
        if (($request->password) || ($request->password_confirmation)) {
            // update aturan validasi
            $validatedData = Validator::make($request->all(),  [
                'nama' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ], [
                'password.required' => 'Password tidak boleh kosong',
                'password.confirmed' => 'Password tidak sama',
                'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
                'nama.required' => 'Nama tidak boleh kosong',
            ]);
        }

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'Data Partai gagal diubah!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // PROSES UPLOAD FILE BARU MULAI
        $namaFile_new = '';

        // jika file di upload
        if($request->profile) {
            $fileUpload = $request->profile;

            // buat nama file baru
            $namaFile_new = $this->randomFileName($fileUpload->getClientOriginalExtension());

            // cek file di dalam local storage
            while (File::exists($this->usersProfile_pathFile($namaFile_new))) {
                // ganti nama file
                $namaFile_new = $this->randomFileName($fileUpload->getClientOriginalExtension());
            }
            
            // simpan file ke dalam local storage
            $fileUpload->move($this->usersProfile_pathFolder(), $namaFile_new);
        }
        // PROSES UPLOAD FILE BARU SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            User::where('id', $id)->update([
                'username' => $request->username,
                'password' => ($request->password)? bcrypt($request->password) : $dataUser->password,
                'nama' => $request->nama,
                'profile' => ($request->profile)? $namaFile_new : $profile_old,
            ]);

            PartaiPolitik::where('id', $request->partai_politik_id)->update([
                'ketua' => $request->ketua,
                'sekretaris' => $request->sekretaris,
                'bendahara' => $request->bendahara,
                'alamat_sekretariat' => $request->alamat_sekretariat,
            ]);

            // PROSES HAPUS FILE LAMA MULAI
            if ($request->profile && ($profile_old !== '')) {
                // jika file ditemukan
                if (File::exists($this->usersProfile_pathFile($profile_old))) {
                    File::delete($this->usersProfile_pathFile($profile_old)); // hapus file
                }
            }
            // PROSES HAPUS FILE LAMA SELESAI
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // PROSES HAPUS FILE BARU MULAI
            if($request->profile) {
                // jika file ditemukan
                if (File::exists($this->usersProfile_pathFile($namaFile_new))) {
                    File::delete($this->usersProfile_pathFile($namaFile_new)); // hapus file
                }
            }
            // PROSES HAPUS FILE BARU SELESAI

            // redirect
            Alert::error('Gagal', 'Data Partai gagal diubah!');
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI
        
        // pindah ke halaman index
        Alert::success('Berhasil', 'Data Partai berhasil diubah!');
        return redirect(route('data-partai.index'));
    }
}
