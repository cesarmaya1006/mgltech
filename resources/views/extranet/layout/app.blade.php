<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/vnd.microsoft.icon" href="{{ asset('imagenes/sistema/mgl_logo') }}" sizes="64x64">
    <title>MGL - Tech</title>
    <link rel="stylesheet" href="{{ asset('css/extranet/general.css') }}">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    @yield('cuerpoPagina')
</body>
</html>
