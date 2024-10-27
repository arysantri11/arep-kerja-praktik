@extends('dashboard.layouts.main')

@section('main-body')
{{-- HEADER MULAI --}}
<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
{{-- HEADER SELESAI --}}

<div class="row">
    <div class="col">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Info</h6>
            </div>
            <div class="card-body">
                {{-- Selamat datang di <strong>CALEG NOW</strong>, anda login sebagai <strong>{{ ucfirst(auth()->user()->role) }}!</strong> --}}
                Selamat datang di <strong>CALEG NOW</strong>, anda login sebagai <strong>Admin!</strong>
            </div>
        </div>
    </div>
</div>
@endsection