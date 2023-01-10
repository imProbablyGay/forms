@extends('_template')

@section('title')
hui
@endsection

@section('main')
<h1>login</h1>
<form action="{{route('login_process')}}" method="post">
    @csrf
    @if (session('data'))
        <h2>{{session('data')}}</h2>
    @endif
    <input type="text" name="name" id="">
    <input type="password" name="password" id="">
    <input type="submit">
</form>
<hr>
<a href="{{ route('register')}}">register</a>
@endsection
