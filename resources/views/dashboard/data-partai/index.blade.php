@extends('dashboard.layouts.main')

@section('main-body')
{{-- HEADER MULAI --}}
<h1 class="mt-4">Data Partai</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Edit Data Partai</li>
</ol>
{{-- HEADER SELESAI --}}

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('data-partai.update', $dataUser->id) }}" method="post" class="g-3 py-4 px-4"  enctype="multipart/form-data">
            @method('PUT')
            @csrf
    
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $dataUser->username }}" required readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password <span class="text-muted font-italic">(Isi jika ingin mengubah password)</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    
                    <!-- code -->
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                    
                    <!-- code -->
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama{{ ($dataUser->role == 2)? ' Partai' : '' }}<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $dataUser->nama) }}" required>
                    
                    <!-- code -->
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="profile" class="form-label">Profile <span class="text-muted font-italic">(Isi jika ingin mengubah profile)</span></label>
                    <input type="file" class="form-control" id="profile" name="profile" accept="image/*">
                </div>
            </div>

            <input type="hidden" name="partai_politik_id" value="{{ $dataPartai->id }}" required>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ketua" class="form-label">Ketua</label>
                    <input type="text" class="form-control" id="ketua" name="ketua" value="{{ old('ketua', $dataPartai->ketua) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sekretaris" class="form-label">Sekretaris</label>
                    <input type="text" class="form-control" id="sekretaris" name="sekretaris" value="{{ old('sekretaris', $dataPartai->sekretaris) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bendahara" class="form-label">Bendahara</label>
                    <input type="text" class="form-control" id="bendahara" name="bendahara" value="{{ old('bendahara', $dataPartai->bendahara) }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="alamat_sekretariat" class="form-label">Alamat Sekretariat</label>
                    <textarea name="alamat_sekretariat" id="alamat_sekretariat" class="form-control" rows="3">{{ old('alamat_sekretariat', $dataPartai->alamat_sekretariat) }}</textarea>
                </div>
            </div>
    
            <div class="row mt-5 text-center">
                <div class="col">
                    <button type="reset" class="btn btn-secondary">Bersihkan</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection