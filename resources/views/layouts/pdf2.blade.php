<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('admin_panel/plugins/bootstrap/css/bootstrap.css') }}"> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">     --}}
    <link rel="stylesheet" href="{{ asset('css/pdfBootstrap.css') }}">

    <style>
        .imagen {
            height: 100px;
            width: 200px;
        }

        @page {
            margin: 100px 55px;
            margin-bottom: 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 15%;
            line-height: 14px;
            font-size: 14px;
        }


        body {
            height: 80%;
            margin-bottom: 4%;
            margin-top: 4%;
            line-height: 12px;
            font-size: 12px;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0px;
            right: 0px;
            height: 10%;
        }

        p {
            /* page-break-after: always; */
        }

        p:last-child {
            /* page-break-after: never; */
        }
    </style>
</head>
<header>

    <div class="row" style="height: 100px">
        <div class="img">

            <img class="imagen" src="{{asset("images/logo2.jpeg")}}" alt="">
        </div>
        <div class="justify-content-center">
            <div class="text-center">

                <h5><strong>MyG Sublimacion</strong></h5>
                <h6><strong>Direccion, Nxxxx Apóstoles, Misiones</strong></h6>
                <h6><strong>Telefono: (03758) xx-xxxx</strong></h6>

            </div>
        </div>
        <div class="float-right" style="font-size: 12px">
            <h6><strong>Fecha:</strong> {{ Carbon\Carbon::now()->format('d/m/Y') }}</h6>
            <h6><strong>Hora:</strong> {{ Carbon\Carbon::now()->format('H:i' ) }}</h6>
            <h6><strong>Emisor:</strong> {{ auth()->user()->apellido .' '. auth()->user()->name }}</h6>
        </div>
    </div>
</header>

<body>

    @yield('content')

</body>
<footer></footer>

</html>