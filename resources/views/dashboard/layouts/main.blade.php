<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="{{ asset('') }}" type="image/x-icon">

        <title>Pendaftaran Caleg</title>

        {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" /> --}}

        {{-- bootstrap css --}}
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

        {{-- bootstrap datatables css --}}
        <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

        {{-- fontawesome online --}}
        {{-- <script src="https://kit.fontawesome.com/5d95be6567.js" crossorigin="anonymous"></script> --}}

        {{-- fontawesome offline --}}
        <link rel="stylesheet" href="{{ asset('fontawesome-6.4.2/css/all.min.css') }}">

        {{-- jquery --}}
        <script src="{{ asset('js/jquery-3.6.3.js') }}"></script>
    </head>

    <body class="sb-nav-fixed">
        @include('sweetalert::alert')

        <!-- Topbar Mulai -->
        @include('dashboard.layouts.top-navbar')
        <!-- Topbar Selesai-->

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <!-- Sidebar Mulai-->
                @include('dashboard.layouts.sidebar')
                <!-- Sidebar Selesai-->
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <!-- Content Mulai -->
                        @yield('main-body')
                        <!-- Content Selesai -->
                    </div>
                </main>
                
                <!-- Footer Mulai -->
                @include('dashboard.layouts.footer')
                <!-- Footer Selesai -->
            </div>
        </div>

        <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        
        <!-- data tables -->
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('js/datatables.js') }}"></script>
    </body>
</html>