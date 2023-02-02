@extends('_template')

@section('title')
hui
@endsection

@section('main')
<h1>login</h1>
<form action="{{route('login.update')}}" method="post">
    @csrf
    @if (session('data'))
        <h2>{{session('data')}}</h2>
    @endif
    <input type="text" name="name" id="">
    <input type="password" name="password" id="">
    <label for="remember">Запомнить меня</label>
      <input type="checkbox" name="remember" value="1">
    <input type="submit">
</form>
<hr>
<a href="{{ route('register.index')}}">register</a>
@endsection
