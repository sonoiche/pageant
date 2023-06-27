<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name') }}</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome-free/css/all.min.css') }}" />
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ url('assets/dist/css/adminlte.min.css') }}" />
        <link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toastr.min.css') }}">
        @yield('page-css')
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            @include('layouts.navbar')
            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>{{ $currentPage }}</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                                    <li class="breadcrumb-item active">{{ $currentPage }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>
                @yield('content')
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="float-right d-none d-sm-block"><b>Version</b> 1.0.0</div>
                <strong>Copyright &copy; {{ date('Y') }} <a href="#">{{ config('app.name') }}</a>.</strong> All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ url('assets/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ url('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ url('assets/plugins/toastr/toastr.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ url('assets/dist/js/demo.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
        @yield('page-js')
        <script>
        <?php if(session('success')): ?>
        $(document).ready(function () {
            toastr.success("{{ session('success') }}")
        });
        <?php endif; ?>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        </script>
    </body>
</html>