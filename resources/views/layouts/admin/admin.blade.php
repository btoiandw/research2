<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RDI-KPRU</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/LogoRDI.png') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Extra details for Live View on GitHub Pages -->

    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    {{-- <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet"> --}}

    <!-- Argon CSS
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">-->
    <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap');
    </style>

    {{-- DataTable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="shttps://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">
</head>

<body class="" style="background-color: #ebebeb" style="min-width: 375px">
    {{--  @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        @endauth
--}}
    @include('layouts.admin.side')
    <div class="main-content">
        @include('layouts.admin.nav')
        @include('layouts.admin.header')
        <div class=" container-fluid mt-5">
            @yield('content')
        </div>


    </div>

    {{--  @guest()
            @include('layouts.footers.guest')
        @endguest --}}

    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    @stack('js')
    {{--  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
     --}}
    <!-- Argon JS -->
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
</body>

</html>
