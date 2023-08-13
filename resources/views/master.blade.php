<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $title }} | {{ env('APP_NAME') }}</title>

    @vite([
        'resources/sass/app.scss',
        'resources/css/app.css',
    ])

    @yield('css')
</head>
<body>
<nav class="main_nav">
    @section('sidebar')
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('admin.createReport') }}">Cadastrar</a>
        <a href="{{ route('admin.reports') }}">Lançamentos</a>
        <a href="{{ route('admin.excel') }}">Excel</a>
        <a href="{{ route('auth.logout') }}">Sair</a>
    @show
</nav>

<main class="main_content">
    @yield('content')
</main>

<footer class="main_footer text-sm">
    © {{ env('APP_NAME') }} - Todos os Direitos Reservados
</footer>

<script src="{{ asset('jquery.js') }}"></script>

@vite([
    'resources/js/app.js',
])

@yield('js')
</body>
</html>
