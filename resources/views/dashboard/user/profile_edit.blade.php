@extends('dashboard.layouts.main')

@section('main-body')

<!-- Page Heading Mulai -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Diri</h1>
</div>
<!-- Page Heading Selesai -->

<!-- body -->
<div class="card mb-5 shadow">
    <form action="{{ route('profile.update', 1) }}" method="post" class="g-3 py-4 px-4" enctype="multipart/form-data" autocomplete="off">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ auth()->user()->email }}" required readonly>
                
                <!-- code -->
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="nama" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                <input type="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', auth()->user()->nama) }}" required>
                
                <!-- code -->
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
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
            <div class="col-md-6 mb-3">
                <label for="telp" class="form-label">No HP</label>
                <input type="text" class="form-control" id="telp" name="telp" value="{{ old('telp', auth()->user()->telp) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="profile" class="form-label">Profile <span class="text-muted font-italic">(Isi jika ingin mengubah profile)</span></label>
                <input type="file" class="form-control" id="profile" name="profile" accept="image/*">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                
                <!-- code -->
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
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

@endsection