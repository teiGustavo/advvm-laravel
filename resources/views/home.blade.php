@extends('master')

@section('content')
<div class="text-center w-25">
    <article class="users_user d-flex justify-center align-center text-center">
        <h3>Nome: {{ $user->name }} <br><br> Email: {{ $user->email }}</h3>
    </article>
</div>
@endsection
