@extends('dashboard.layouts.main')

@section('main-body')
{{-- HEADER MULAI --}}
<h1 class="mt-4">Pendaftaran Caleg</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('caleg.pilih_lembaga') }}">Lembaga Legislatif</a></li>
    <li class="breadcrumb-item"><a href="{{ route('caleg.pilih_tahun', $dataTahun->lembaga_legislatif_id) }}">Tahun Pemilihan</a></li>
    <li class="breadcrumb-item active">Daerah Pemilihan</li>
</ol>
{{-- HEADER SELESAI --}}

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">  
                <h5 class="m-0 font-weight-bold">{{ $dataTahun->lembaga_legislatif->nama_lembaga }} ({{ $dataTahun->tahun }})</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr class="bg-success text-light">
                        <th class="text-center" width="20px">No</th>
                        <th class="text-center">Nama Daerah</th>
                        <th>Keterangan</th>
                        <th class="text-center" width="110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    @foreach ($dataTahun->daerah_pemilihan as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center">{{ $item->nama_daerah }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td class="text-center">
                            <a href="{{ route('caleg.index', $item->id) }}" class="btn btn-primary btn-sm">
                                Pilih
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection