<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo-kpu.png') }}">
    <title>Login</title>

    {{-- bootstrap css --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    {{-- my css --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/auth.css') }}"> --}}

    {{-- fontawesome online --}}
    {{-- <script src="https://kit.fontawesome.com/5d95be6567.js" crossorigin="anonymous"></script> --}}

    {{-- fontawesome offline --}}
    <link rel="stylesheet" href="{{ asset('fontawesome-6.4.2/css/all.min.css') }}">

</head>

<body class="h-100 overflow-hidden bg-danger" style="background-size: cover;">
    
    @yield('main-body')

    {{-- bootstrap js --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>