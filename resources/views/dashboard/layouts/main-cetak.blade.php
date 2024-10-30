<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="{{ asset('img/logo-kpu.png') }}" type="image/x-icon">

        <title>{{ $title }}</title>
    </head>

    <style>
        table, th, td {
            border: 1px solid;
        }

        .text-center {
            text-align: center;
        }
    </style>

    <body>
        <!-- Content Mulai -->
        @yield('main-body')
        <!-- Content Selesai -->

        <script>
            window.print();
        </script>
    </body>
</html>