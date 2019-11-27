<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>MyG Sublimacion</title>

  <!-- Font Awesome Icons -->

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_panel/plugins/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_panel/plugins/select2/css/select2.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_panel/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_panel/plugins/chart.js/Chart.min.css') }}">
  <!-- IonIcons -->
  {{-- <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
  {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin_panel/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->

  {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
  <!-- Ion Slider -->
  <link rel="stylesheet" href="{{ asset('admin_panel/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}">
  {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}


  @yield('style')
  <style>
    /* body {
      background-color: #56baed;

    } */

    .btn-pill {
      border-radius: 40px;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Inicio Header -->
    @include('admin_panel/header')
    <!-- Fin Header -->
    <!-- Inicio SideBar -->
    @include('admin_panel/sidebar')
    <!-- Fin SideBar -->
    <!-- Inicio ContentWrapper -->

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">{{--HOlesss--}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              {{-- <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active">Dashboard v3</li>
                            </ol> --}}
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <div class="content">

        {{-- ********Controlador de errores******** --}}
        @include('layouts.mensaje')
        {{-- ******** Fin del controlador de errores*********      --}}
        @yield('content')
      </div>
    </div>


    <!-- Fin ContentWrapper -->
    <!-- Inicio Footer -->
    @include('admin_panel/footer')
    <!-- Fin Footer -->

  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

  <!-- jQuery -->
  <script src="{{asset('admin_panel/plugins/jquery/jquery.min.js')}}"></script>

  <script src="{{asset('admin_panel/plugins/inputmask/jquery.inputmask.bundle.js')}}"></script>


  <!-- Bootstrap 4-->
  <script src="{{asset('admin_panel/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE -->
  <script src="{{asset('admin_panel/dist/js/adminlte.js')}}"></script>
  <!-- AdminLTE App -->
  {{-- <script src="{{asset('admin_panel/dist/js/adminlte.min.js')}}"></script> --}}
  <!-- DataTables -->
  <script src="{{asset('admin_panel/plugins/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{asset('admin_panel/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
  <script src="{{asset('admin_panel/plugins/select2/js/select2.js')}}"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="{{asset('admin_panel/plugins/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('admin_panel/plugins/moment/moment-with-locales.min.js')}}"></script>

  <script src="{{asset('admin_panel/dist/js/demo.js')}}"></script>
  {{-- java script interact --}}
  <script src="{{asset('js/interactjs.js')}}"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script> --}}

  <!-- Ion Slider -->
  <script src="{{asset('admin_panel/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>



  @stack('scripts')

</body>

</html>

@yield('htmlFinal')
<script>
  $('.select2').select2();
  $('[data-mask]').inputmask();
  $('.dropdown-toggle').dropdown();
</script>