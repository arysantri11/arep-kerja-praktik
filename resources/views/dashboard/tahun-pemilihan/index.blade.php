@extends('dashboard.layouts.main')

@section('main-body')
{{-- HEADER MULAI --}}
<h1 class="mt-4">Tahun Pemilihan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Index</li>
</ol>
{{-- HEADER SELESAI --}}

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">  
                <h5 class="m-0 font-weight-bold">Data Tahun</h5>
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
                                <h5 class="modal-title" id="ModalLabelTambah">Tambah Tahun Pemilihan </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('tahun-pemilihan.store') }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="lembaga_legislatif_id" class="form-label">Lembaga Legislatif<span class="text-danger">*</span></label>
                                            <select name="lembaga_legislatif_id" class="form-control" id="lembaga_legislatif_id" required>
                                                <option value="">-- Pilih Lembaga --</option>

                                                @foreach ($dataLembaga as $itemLembaga)
                                                    <option value="{{ $itemLembaga->id }}">
                                                        {{ $itemLembaga->nama_lembaga }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="tahun" class="form-label">Tahun<span class="text-danger">*</span></label>
                                            <input type="number" min="0" class="form-control" id="tahun" name="tahun" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="tanggal" class="form-label">Tanggal<span class="text-danger">*</span></label>
                                            <input type="date" min="0" class="form-control" id="tanggal" name="tanggal" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
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
                        <th class="text-center">Lembaga</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center" width="110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    @foreach ($dataTahunPemilihan as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center">{{ $item->lembaga_legislatif->nama_lembaga }}</td>
                        <td class="text-center">{{ $item->tahun }}</td>
                        <td class="text-center">{{ Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}</td>
                        <td class="text-center">{{ $item->keterangan }}</td>
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
                                        <form action="{{ route('tahun-pemilihan.destroy', $item->id) }}" method="POST" autocomplete="off">
                                            @method('delete')
                                            @csrf
    
                                            <p>Apakah anda yakin ingin menghapus data ini? </p>
                                            <p>
                                                <b>{{ $item->tahun .' ('. $item->tanggal .')' }}</b>
                                            </p>
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
                                        <h5 class="modal-title" id="ModalLabelEdit">Edit Tahun Pemilihan </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('tahun-pemilihan.update', $item->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="" class="form-label">Lembaga Legislatif</label>
                                                    <p><b>
                                                        {{ $item->lembaga_legislatif->nama_lembaga }}
                                                    </b></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="tahun" class="form-label">Tahun<span class="text-danger">*</span></label>
                                                    <input type="number" min="0" class="form-control" id="tahun" name="tahun" value="{{ $item->tahun }}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="tanggal" class="form-label">Tanggal<span class="text-danger">*</span></label>
                                                    <input type="date" min="0" class="form-control" id="tanggal" name="tanggal" value="{{ $item->tanggal }}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3">{{ $item->keterangan }}</textarea>
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