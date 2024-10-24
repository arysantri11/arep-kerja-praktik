@extends('dashboard.layouts.main')

@section('main-body')
{{-- HEADER MULAI --}}
<h1 class="mt-4">Lembaga Legislatif</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Index</li>
</ol>
{{-- HEADER SELESAI --}}

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">  
                <h5 class="m-0 font-weight-bold">Data Lembaga</h5>
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
                                <h5 class="modal-title" id="ModalLabelTambah">Tambah Lembaga </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('lembaga-legislatif.store') }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="nama_lembaga" class="form-label">Nama Lembaga<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nama_lembaga') is-invalid @enderror" id="nama_lembaga" name="nama_lembaga" required>

                                            <!-- code -->
                                            @error('nama_lembaga')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
                        <th>Nama Lembaga</th>
                        <th class="text-center" width="110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    @foreach ($dataLembagaLegislatif as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item->nama_lembaga }}</td>
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
                                        <form action="{{ route('lembaga-legislatif.destroy', $item->id) }}" method="POST" autocomplete="off">
                                            @method('delete')
                                            @csrf
    
                                            <p>Apakah anda yakin ingin menghapus data ini? </p>
                                            <p><b>{{ $item->nama_lembaga }}</b></p>
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
                                        <h5 class="modal-title" id="ModalLabelEdit">Edit Lembaga </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('lembaga-legislatif.update', $item->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="nama_lembaga" class="form-label">Nama Lembaga<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('nama_lembaga') is-invalid @enderror" id="nama_lembaga" name="nama_lembaga" value="{{ $item->nama_lembaga }}" required>

                                                    <!-- code -->
                                                    @error('nama_lembaga')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
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