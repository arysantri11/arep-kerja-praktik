<?php

namespace App\Http\Controllers;

use App\Models\PartaiPolitik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.user.index', [
            'title'   => 'User',
            'nav_active' => 'menu-user',
            'dataUser' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // PROSES VALIDASI MULAI
        // membuat validasi data yang di input user
        $validatedData = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'nama' => 'required',
            'role' => 'required',
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'username.unique' => 'Username telah digunakan',
            'password.required' => 'Password tidak boleh kosong',
            'password.confirmed' => 'Password tidak sama',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'role.required' => 'Pilih role terlebih dahulu',
        ]);

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'User gagal ditambahkan!');
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('failed', $validatedData->errors()->all());
        }
        // PROSES VALIDASI SELESAI

        // PROSES UPLOAD PROFILE MULAI
        $namaFile = ''; // default nama file

        // logic = jika file di upload
        if($request->profile) {
            $fileUpload = $request->profile;
            $namaFile = $this->randomFileName($fileUpload->getClientOriginalExtension());

            // cek file di dalam local storage
            while (File::exists($this->usersProfile_pathFile($namaFile))) {
                // ganti nama file
                $namaFile = $this->randomFileName($fileUpload->getClientOriginalExtension());
            }
    
            // simpan file ke dalam local storage
            $fileUpload->move($this->usersProfile_pathFolder(), $namaFile);
        }
        // PROSES UPLOAD PROFILE SELESAI

        // SIMPAN DATA KE DALAM DATABASE MULAI
        try {
            User::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'nama' => $request->nama,
                'profile' => $namaFile,
                'role' => $request->role,
            ]);

            // membuat data partai baru secara otomatis
            $dataUserBaru = User::where('username', $request->username)->first();

            PartaiPolitik::create([
                'user_id' => $dataUserBaru->id,
            ]);
        } catch (\Throwable $th) {
            // dd($th->getMessage());

            // PROSES HAPUS FILE MULAI
            // jika file diupload
            if($request->profile) {
                // jika file ditemukan
                if (File::exists($this->usersProfile_pathFile($namaFile))) {
                    File::delete($this->usersProfile_pathFile($namaFile)); // hapus file
                }
            }
            // PROSES HAPUS FILE SELESAI

            // redirect
            Alert::error('Gagal', 'User gagal ditambahkan!');
            // return redirect()->back()->with('failed', '<strong>Data User Gagal Disimpan</strong> : ' . $th->getMessage());
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI

        // redirect
        Alert::success('Berhasil', 'User berhasil ditambahkan!');
        return redirect()->route('user.index');
    }

    public function update(Request $request, string $id)
    {
        // ambil data berdasarkan id
        $dataUser = User::where('id', $id)->first();
        $profile_old = $dataUser->profile; // profile lama

        // PROSES VALIDASI MULAI
        // membuat aturan validasi
        $validatedData = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'role' => 'required',
            'aktif' => 'required',
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'role.required' => 'Pilih role terlebih dahulu',
            'aktif.required' => 'Pilih aktif terlebih dahulu',
        ]);

        // jika password di edit
        if (($request->password) || ($request->password_confirmation)) {
            // update aturan validasi
            $validatedData = Validator::make($request->all(),  [
                'username' => 'required',
                'nama' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'role' => 'required',
                'status' => 'required',
            ], [
                'username.required' => 'Username tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
                'password.confirmed' => 'Password tidak sama',
                'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
                'nama.required' => 'Nama tidak boleh kosong',
                'role.required' => 'Pilih role terlebih dahulu',
                'status.required' => 'Pilih status terlebih dahulu',
            ]);
        }

        // jika tidak lolos validasi
        if($validatedData->fails()) {
            Alert::error('Gagal', 'User gagal diubah!');
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
            User::where('id', $id)->update(
                [
                    'username' => $request->username,
                    'password' => ($request->password)? bcrypt($request->password) : $dataUser->password,
                    'nama' => $request->nama,
                    'role' => $request->role,
                    'aktif' => $request->aktif,
                    'profile' => ($request->profile)? $namaFile_new : $profile_old,
                ]
            );

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
            Alert::error('Gagal', 'User gagal diubah!');
            return redirect()->back();
        }
        // SIMPAN DATA KE DALAM DATABASE SELESAI
        
        // pindah ke halaman index
        Alert::success('Berhasil', 'User berhasil diubah!');
        return redirect(route('user.index'));
    }

    public function destroy(string $id)
    {
        try {
            // menghapus sebuah data pada database
            $dataUser = User::where('id', $id)->first();
            $profileUser = $dataUser->profile;
            $dataUser->delete();

            // PROSES HAPUS FILE MULAI
            // jika data tidak kosong
            if ($profileUser !== '') {
                // jika file ditemukan
                if (File::exists($this->usersProfile_pathFile($profileUser))) {
                    File::delete($this->usersProfile_pathFile($profileUser)); // hapus file
                }
            }
            // PROSES HAPUS FILE SELESAI
        } catch (\Throwable $th) {
            // redirect
            Alert::error('Gagal', 'User gagal dihapus!');
            return redirect()->back();
        }

        // redirect
        Alert::success('Berhasil', 'User berhasil dihapus!');
        return redirect()->back();
    }
}
