<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informacion sobre materia primas</title>
</head>

<body>
    <h3>Hola {{$proveedor->nombre}} nos gustaria conocer acerca de sus productos</h3>
    <div>

        <p>Necesitamos hacer compras de materias primas que se encuentra en este enlace <a
                href="{{ route('proveedor.obtenerPrecios', $proveedor->id) }}">
                <h2>Click Aqui</h2>
            </a></p>
    </div>
    <p>Anteriormente le compramos las siguientes materias primas</p>
    <ul>
        <p>Materias Primas</p>
        @foreach ($proveedor->materiaPrimas as $mate)
        <li>{{$mate->nombre}}</li>
        @endforeach
    </ul>
</body>

</html>