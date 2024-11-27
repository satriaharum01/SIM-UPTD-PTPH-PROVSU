<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta10
* @link https://tabler.io
* Copyright 2018-2022 The Tabler Authors
* Copyright 2018-2022 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ env('APP_NAME') }}</title>
    <!-- CSS files -->
    
    <link href="{{ asset('landing/login/img/logo-dikdasmen.png') }}" rel="icon">
    <link href="<?= asset('landing/login/dist/css/tabler.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('landing/login/dist/css/tabler-flags.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('landing/login/dist/css/tabler-payments.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('landing/login/dist/css/tabler-vendors.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('landing/login/dist/css/demo.min.css') ?>" rel="stylesheet" />
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .bg-custom{
            background-image: url('landing/login/img/bg-login.jpg');
        }
    </style>
</head>

<body class="border-top-wide border-primary d-flex flex-column bg-custom">
    <div class="page page-center">
        <div class="container-tight py-4">
            @yield('content')
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="<?= asset('landing/login/dist/js/tabler.min.js') ?>"></script>
    <script src="<?= asset('landing/login/dist/js/demo.min.js') ?>"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    @yield('js')
</body>

</html>