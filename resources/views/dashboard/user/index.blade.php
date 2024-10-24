@extends('dashboard.layouts.main')

@section('main-body')
{{-- HEADER MULAI --}}
<h1 class="mt-4">User</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Index</li>
</ol>
{{-- HEADER SELESAI --}}

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">  
                <h5 class="m-0 font-weight-bold">Data User</h5>
            </div>
            <div class="col text-end">
                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fa fa-plus"></i> Tambah
                </a>
                {{-- <a href="{{ route('user.laporan') }}" class="btn btn-sm btn-warning" target="_blank">
                    <i class="fa fa-print"></i> Cetak
                </a> --}}

                {{-- Modal Tambah Mulai --}}
                <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="ModalLabelTambah" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabelTambah">Tambah User </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                                            
                                            <!-- code -->
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="nama" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                            
                                            <!-- code -->
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                                            
                                            <!-- code -->
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                                            <select name="role" class="form-control" id="role" required>
                                                <option value="">-- Pilih Role --</option>

                                                <option value="1">Admin KPU</option>
                                                <option value="2">Admin Partai</option>
                                            </select>
                                            
                                            <!-- code -->
                                            @error('role')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="profile" class="form-label">Profile</label>
                                            <input type="file" class="form-control" id="profile" name="profile" accept="image/*">
                                        </div>
                                    </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-disk"></i>
                                    Simpan
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Modal Tambah Selesai --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr class="bg-success text-light">
                        <th class="text-center" width="20px">No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th class="text-center">Profile</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Aktif</th>
                        <th class="text-center" width="110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    @foreach ($dataUser as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->nama }}</td>
                        <td class="text-center">
                            @if ($item->profile)
                                <img src="{{ asset('img/users/profile/'. $item->profile) }}" alt="profile" class="rounded-circle" style="width: 35px; height: 35px;">
                            @else
                                {{-- <img src="{{ asset('img/users/profile/user.jpg') }}" alt="profile" class="rounded-circle" style="width: 35px"> --}}
                                <i class="fas fa-user fa-fw">
                            @endif
                        </td>
                        <td class="text-center">{{ ($item->role == '1')? 'Admin KPU' : 'Admin Partai' }}</td>
                        <td class="text-center">
                            @if ($item->aktif == 'y')
                                <span class="badge text-bg-success">
                                    Aktif
                                </span>
                            @else
                                <span class="badge text-bg-danger">
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-warning btn-circle btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $item->id }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        
                        {{-- Modal Delete Mulai --}}
                        <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="ModalLabelDelete" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ModalLabelDelete">Pemberitahuan !</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('user.destroy', $item->id) }}" method="POST" autocomplete="off">
                                            @method('delete')
                                            @csrf
    
                                            <p>Apakah anda yakin ingin menghapus data ini? </p>
                                            <p><b>{{ $item->username }}</b></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                            Hapus
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- Modal Delete Selesai --}}
                        
                        {{-- Modal Edit Mulai --}}
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="ModalLabelEdit" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ModalLabelEdit">Edit User </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('user.update', $item->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="username" name="username" value="{{ $item->username }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="nama" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $item->nama }}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="password" class="form-label">Password <span class="text-muted font-italic">(Isi jika ingin mengubah password)</span></label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                                    
                                                    <!-- code -->
                                                    @error('password')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
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
                                                <div class="col mb-3 text-start">
                                                    <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                                                    <select name="role" class="form-control" id="role" required>
                                                        <option value="">-- Pilih Role --</option>
        
                                                        <option value="1" {{  ($item->role == '1') ? 'selected' : '' }}>Admin KPU</option>
                                                        <option value="2" {{  ($item->role == '2') ? 'selected' : '' }}>Admin Partai</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="aktif" class="form-label">Aktif<span class="text-danger">*</span></label>
                                                    <select name="aktif" class="form-control" id="aktif" required>
                                                        <option value="">-- Pilih --</option>

                                                        <option value="y" {{ ($item->aktif == 'y') ? 'selected' : '' }}>Aktif</option>
                                                        <option value="n" {{ ($item->aktif == 'n') ? 'selected' : '' }}>Nonaktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="profile" class="form-label">Profile</label>
                                                    <input type="file" class="form-control" id="profile" name="profile" accept="image/*">
                                                </div>
                                            </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-floppy-disk"></i>
                                                Simpan
                                            </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- Modal Edit Selesai --}}
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection