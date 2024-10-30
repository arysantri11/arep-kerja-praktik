@extends('dashboard.layouts.main')

@section('main-body')
{{-- HEADER MULAI --}}
<h1 class="mt-4">Pendaftaran Caleg</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('caleg.pilih_lembaga') }}">Lembaga Legislatif</a></li>
    <li class="breadcrumb-item"><a href="{{ route('caleg.pilih_tahun', $dataDapil->tahun_pemilihan->lembaga_legislatif_id) }}">Tahun Pemilihan</a></li>
    <li class="breadcrumb-item"><a href="{{ route('caleg.pilih_dapil', $dataDapil->tahun_pemilihan_id) }}">Daerah Pemilihan</a></li>
    <li class="breadcrumb-item active">Daerah Pemilihan</li>
</ol>
{{-- HEADER SELESAI --}}

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">  
                <h5 class="m-0 font-weight-bold">{{ $dataDapil->tahun_pemilihan->lembaga_legislatif->nama_lembaga }} ({{ $dataDapil->tahun_pemilihan->tahun }} - {{ $dataDapil->nama_daerah }})</h5>
            </div>
            <div class="col text-end">
                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fa fa-plus"></i> Tambah Caleg Baru
                </a>
                {{-- <a href="{{ route('user.laporan') }}" class="btn btn-sm btn-warning" target="_blank">
                    <i class="fa fa-print"></i> Cetak
                </a> --}}

                {{-- Modal Tambah Mulai --}}
                <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="ModalLabelTambah" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabelTambah">Tambah Caleg </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('caleg.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="partai_id" value="{{ $dataPartai->id }}" required>
                                    <input type="hidden" name="daerah_pemilihan_id" value="{{ $dataDapil->id }}" required>

                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" required>
                                            
                                            <!-- code -->
                                            @error('nama_lengkap')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin<span class="text-danger">*</span></label>
                                            <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                                                <option value="">-- Pilih --</option>

                                                <option value="l">Laki - Laki</option>
                                                <option value="p">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="tempat_lahir" class="form-label">Tempat Lahir<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" required>
                                            
                                            <!-- code -->
                                            @error('tempat_lahir')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" required>
                                            
                                            <!-- code -->
                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="status" class="form-label">Status</label>
                                            <input type="text" class="form-control" id="status" name="status">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="foto" class="form-label">Foto</label>
                                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 text-start">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
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
                        <th class="text-center">Foto</th>
                        <th>Nama</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Tempat/Tanggal Lahir</th>
                        <th class="text-center" width="110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    @foreach ($dataDapil->caleg->sortByDesc('id') as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center">
                            @if ($item->foto)
                                <img src="{{ asset('img/caleg/foto/'. $item->foto) }}" alt="foto" class="rounded-circle" style="width: 35px; height: 35px;">
                            @else
                                {{-- <img src="{{ asset('img/caleg/foto/user.jpg') }}" alt="foto" class="rounded-circle" style="width: 35px"> --}}
                                <i class="fas fa-user fa-fw">
                            @endif
                        </td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td class="text-center">{{ ($item->jenis_kelamin == 'l')? 'Laki - Laki' : 'Perempuan' }}</td>
                        <td class="text-center">{{ $item->tempat_lahir }}, {{ Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
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
                                        <form action="{{ route('caleg.destroy', $item->id) }}" method="POST" autocomplete="off">
                                            @method('delete')
                                            @csrf
    
                                            <p>Apakah anda yakin ingin menghapus data ini? </p>
                                            <p><b>{{ $item->nama_lengkap }}</b></p>
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
                                        <h5 class="modal-title" id="ModalLabelEdit">Edit Caleg </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('caleg.update', $item->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="nama_lengkap" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ $item->nama_lengkap }}" required>
                                                    
                                                    <!-- code -->
                                                    @error('nama_lengkap')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin<span class="text-danger">*</span></label>
                                                    <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                                                        <option value="">-- Pilih --</option>
        
                                                        <option value="l" {{ ($item->jenis_kelamin == 'l')? 'selected' : '' }}>Laki - Laki</option>
                                                        <option value="p" {{ ($item->jenis_kelamin == 'p')? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="tempat_lahir" class="form-label">Tempat Lahir<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ $item->tempat_lahir }}" required>
                                                    
                                                    <!-- code -->
                                                    @error('tempat_lahir')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ $item->tanggal_lahir }}" required>
                                                    
                                                    <!-- code -->
                                                    @error('tanggal_lahir')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ $item->pekerjaan }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="status" class="form-label">Status</label>
                                                    <input type="text" class="form-control" id="status" name="status" value="{{ $item->status }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="foto" class="form-label">Foto <span class="text-muted font-italic">(Isi jika ingin mengubah profile)</span></label>
                                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3 text-start">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <textarea class="form-control" name="alamat" id="alamat" rows="3">{{ $item->alamat }}</textarea>
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