@extends('auth.layouts.main')

@section('main-body')

<div class="row justify-content-center mx-1" style="height: 100vh;">
    <div class="col-lg-4 my-auto ">
        <div class="bg-light rounded-3 shadow">
            <div class="form-login mx-3 text-center pb-3 pt-3">
                <div class="row">
                    <div class="col-1">
                        <img src="{{ asset('img/logo-kpu.png') }}" alt="Logo" width="30px" class="">
                    </div>
                    <div class="col">
                        <p class="fs-3 fw-semibold ms-2 my-auto" style="color: rgb(67, 67, 67)">Login</p>
                    </div>
                </div>
                <hr class="text-secondary">

                {{-- Notifikasi gagal mulai --}}
                @if (session()->has('gagal'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! session('gagal') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                {{-- Notifikasi gagal selesai --}}

                <form action="" method="post" class="form mt-4 text-center">
                    @csrf
        
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="username"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" aria-label="Username" aria-describedby="username" required autofocus>
                    </div>
        
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="password"><i class="fa fa-key"></i></span>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password" aria-describedby="password" required>
                    </div>
        
                    <button type="submit" class="btn btn-primary my-2"><i class="fa fa-arrow-right-to-bracket"></i> Login</button>
                </form>
                {{-- <div class="my-3 text-center">
                    <a href="/" class="link-primary">&laquo; Back to Dashboard</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>

{{-- Notifikasi logout berhasil mulai --}}
@if (session()->has('logoutBerhasil'))
    {!! session('logoutBerhasil') !!}
@endif
{{-- Notifikasi logout berhasil selesai --}}

@endsection