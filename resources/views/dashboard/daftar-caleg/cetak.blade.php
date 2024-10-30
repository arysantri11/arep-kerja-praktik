@extends('dashboard.layouts.main-cetak')

@section('main-body')
{{-- HEADER MULAI --}}
<div class="text-center">
    <img src="{{ asset('img/logo-kpu.png') }}" alt="logo" style="width: 100px; height: 100px;">
</div>

<h2 class="text-center">Daftar Calon Tetap (DCT)</h2>
<h3 class="text-center">
    {{ $dataDapil->tahun_pemilihan->lembaga_legislatif->nama_lembaga }} Tahun {{ $dataDapil->tahun_pemilihan->tahun }} ({{ $dataDapil->nama_daerah }})
</h3>
{{-- HEADER SELESAI --}}

<?php $noPartai = 1 ?>
@foreach ($dataCetak as $item)
<table width="100%" cellspacing="0">
    <thead>
        <tr>
            <th style="border: none; font-size: 40px" colspan="2">{{ $noPartai++ }}</th>
            <th style="border: none; font-size: 20px" colspan="2">{{ $item['dataUser']->nama }}</th>
            <th style="border: none;" width="100px">
                @if ($item['dataUser']->profile)
                    <img src="{{ asset('img/users/profile/'. $item['dataUser']->profile) }}" alt="foto" class="rounded-circle" style="width: 35px; height: 35px;">
                @else
                    {{-- <img src="{{ asset('img/caleg/foto/user.jpg') }}" alt="foto" class="rounded-circle" style="width: 35px"> --}}
                    <i class="fas fa-user fa-fw">
                @endif
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th width="20px">No</th>
            <th width="50px">Foto</th>
            <th>Nama</th>
            <th width="400px">Tempat/Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
        </tr>
    </thead>
    <tbody>
        <?php $noCaleg = 1 ?>
        @foreach ($item['dataCaleg']->sortByDesc('id') as $itemCaleg)
        <tr>
            <td class="text-center">{{ $noCaleg++ }}</td>
            <td class="text-center">
                @if ($itemCaleg->foto)
                    <img src="{{ asset('img/caleg/foto/'. $itemCaleg->foto) }}" alt="foto" class="rounded-circle" style="width: 35px; height: 35px;">
                @else
                    {{-- <img src="{{ asset('img/caleg/foto/user.jpg') }}" alt="foto" class="rounded-circle" style="width: 35px"> --}}
                    <i class="fas fa-user fa-fw">
                @endif
            </td>
            <td class="text-center">{{ $itemCaleg->nama_lengkap }}</td>
            <td class="text-center">{{ $itemCaleg->tempat_lahir }}, {{ Carbon\Carbon::parse($itemCaleg->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
            <td class="text-center">{{ ($itemCaleg->jenis_kelamin == 'l')? 'Laki - Laki' : 'Perempuan' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br><br>
@endforeach

@endsection