<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>K Taxi</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
{{--    cdn for jquery--}}
{{--    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>--}}
    <script type="text/javascript" src="{{asset('asset/js/jquery.js')}}"></script>
    {{--cdn for open layer map--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/ol@v8.1.0/dist/ol.js"></script>--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.1.0/ol.css">--}}
        <link rel="stylesheet" href="{{asset('asset/openlayer/ol.css')}}">
        <script type="text/javascript" src="{{asset('/asset/openlayer/dist/ol.js')}}"></script>

</head>

<body id="body-pd">
    @yield('layout')
</body>
</html>
