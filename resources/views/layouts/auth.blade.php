<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <x-site-title>
        @yield('title')
    </x-site-title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    @stack('prepend-style')
    @include('includes.style')
    @stack('addon-style')

</head>

<body>
    {{ $slot }}


    @stack('prepend-script')
    @vite(['resources/js/app.js'])
    @stack('addon-script')
</body>

</html>