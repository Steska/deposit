@extends('layouts.app')

@section('content')
    <form action="/login" method="POST">
        <p>
        <label for="login">Login</label>
        <input type="text" name="login" id="login" class="@error('login') is-invalid @enderror">
        </p>
        <p>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror">
        </p>
    </form>
@stop
