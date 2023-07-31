@extends('master')

@section('sidebar')
    <a href="{{ route('auth.login') }}">Logar-se</a>
@endsection

@section('content')
    <div class="container">
        <h3 class="text-light">Por enquanto esta função não está disponível,</h3>
        <h3 class="text-light mt-1">Entre em contato com o administrador para mais detalhes.</h3>
    </div>
@endsection
