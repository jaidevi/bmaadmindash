<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="base_url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Der Divyaraj') }} | On Demand Fuel Request-Providing (Gas Diesel Petrol Gasoline)</title>
    <!-- Favicon -->
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->

    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Argon CSS -->
    {{-- <link type="text/css" href="{{ asset('argon') }}/css/datables.css" rel="stylesheet"> --}}
    <link type="text/css" href="{{ asset('argon') }}/css/ownDatatable.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    
    <!-- Datatabele -->


    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css" /> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"> --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">

    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    @stack('css')
</head>

<body class="{{ $class ?? '' }}">
    @auth()
    <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
    @include('layouts.navbars.sidebar')
    @endauth

    @if (AUth::check())
        <div class="main-content">
            @include('layouts.navbars.navbar')
            <?php $license_status = \App\AdminSetting::first()->license_status; ?>
                    @if ($license_status == 1)
                        @yield('content')
                        @yield('content_setting')
                    @else
                            <script>
                                var base_url = $('meta[name=base_url]').attr("content");
                                var curr_url = window.location.href;
                                var set_url = base_url+'/setting';
                                if (curr_url != set_url)
                                {
                                    setTimeout(() => {
                                        Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Your License has been deactivated...!!',
                                        onClose: () => {
                                            window.location.replace(set_url);
                                            }
                                        })
                                    }, 1000);
                                }
                            </script>
                        @yield('content_setting')
            
                    @endif
            </div>
    @else
        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')

        </div>
    @endif

    @guest()
    @include('layouts.footers.guest')
    @endguest

    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    @stack('js')

    <!-- Argon JS -->

    {{-- datatable --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/datatables.min.js">

    </script>
    <script src="{{ asset('argon') }}/js/custom/custom.js"></script>
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
</body>

</html>