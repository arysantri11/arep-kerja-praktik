@extends('dashboard.layouts.main')

@section('main-body')
{{-- HEADER MULAI --}}
<h1 class="mt-4">Daftar Caleg</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('daftar-caleg.pilih_lembaga') }}">Lembaga Legislatif</a></li>
    <li class="breadcrumb-item"><a href="{{ route('daftar-caleg.pilih_tahun', $dataDapil->tahun_pemilihan->lembaga_legislatif_id) }}">Tahun Pemilihan</a></li>
    <li class="breadcrumb-item"><a href="{{ route('daftar-caleg.pilih_dapil', $dataDapil->tahun_pemilihan_id) }}">Daerah Pemilihan</a></li>
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
                <a href="{{ route('daftar-caleg.cetak', $dataDapil->id) }}" class="btn btn-sm btn-warning" target="_blank">
                    <i class="fa fa-print"></i> Cetak
                </a>
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
                        <th class="text-center">Partai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    @foreach ($dataCaleg->sortByDesc('id') as $item)
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
                        <td class="text-center">{{ $item->partai_politik->users->nama }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection