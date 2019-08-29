<html>
    <head>
        <title>Sistema- @yield('head') </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    </head>
    <body>
        <nav class="navbar navbar-dark bg-primary">
            <a href="#" class="navbar-brand">Home</a>

        </nav>
        <div class="row">
            @yield('titulo')
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @yield('contenidoCentral')
                </div>
                <div class="col-md-4">
                    @yield('contenidoDerecho')
                </div>
            </div>
        </div>
<br>
        <div class="row">
            @yield('pie')
        </div>
        
    </body>
</html>