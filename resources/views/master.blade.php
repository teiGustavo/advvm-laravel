<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('css')

    <title> {{ $title }} | {{ env('APP_NAME') }}</title>
</head>
<body>
<nav class="main_nav">
    @section('sidebar')
        <a href="{{ route('home') }}">Home</a>
        <a href="">Cadastrar</a>
        <a href="{{ route('admin.reports') }}">Lançamentos</a>
        <a href="">Excel</a>
        <a href="{{ route('auth.logout') }}">Sair</a>
    @show
</nav>

<main class="main_content">
    @yield('content')
</main>

<footer class="main_footer">
    © {{ env('APP_NAME') }} - Todos os Direitos Reservados
</footer>


<script src="{{ asset('js/jquery.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>

@yield('js')
</body>
</html>
