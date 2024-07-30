<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <base href="/">
    <title>{{ $config->app }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ str_replace('&nbsp;', ' ', strip_tags($config->description)) }}" />
    <meta name="keywords"
        content="{{ $config->app }}, {{ str_replace('&nbsp;', ' ', strip_tags($config->description)) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="{{ $config->app }}">
    <link rel="shortcut icon" href="{{ $config->logo_depan }}" />
    <link name="gfont" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    {{-- <script src="{{ asset('assets/css/plugins.bundle.css') }}"></script> --}}
    {{-- <script src="{{ asset('assets/css/style.bundle.css') }}"></script> --}}

    {{-- <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script> --}}
    <script src="{{ asset('assets/js/fslightbox.js') }}"></script>

    {{-- @vite('resources/js/bootstrap.js') --}}
    @vite('resources/js/app.ts')
</head>

<body>
    <div id="app"></div>
</body>

</html>
