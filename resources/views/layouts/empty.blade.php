<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bookshop: @yield('title')</title>

    <!-- Icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('/images/icon/favicon-16x16.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('fonts/themify-icons/themify-icons.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ URL::asset('/css/reset.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/basic.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/media.css') }}">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ URL::asset('js/main.js') }}" charset="utf-8"></script>
</head>
<body>
@include('layouts.preloader')
<header class="auth-header">
    <a href="/"><img src="{{ URL::asset('/images/header/logo.png') }}" alt="logo" class="header-logo"></a>
</header>
@yield('content')
</body>
</html>