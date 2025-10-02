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

    <x-topbar-layout />

    <x-menu-layout />

    <div class="startbar-overlay d-print-none"></div>
    <!-- end leftbar-tab-menu-->
    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content">

            {{ $slot }}

            <x-footer-layout />

        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    @stack('prepend-script')
    @vite(['resources/js/app.js'])
    @include('includes.script')
    @stack('addon-script')
</body>
<!--end body-->

</html>