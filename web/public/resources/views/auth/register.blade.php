@extends('_template')

@section('title')
hui 2
@endsection

@section('main')
<h1>register</h1>
<form action="{{ route('register.store')}}" method="post">
    @forelse ($errors->all() as $error)
        <span style="color:red;">{{$error}}</span>
    @empty
    @endforelse
    @csrf
    <input type="text" name="email" id="" @error('email') style='border:2px solid red;' @enderror>
    <input type="text" name="name" id="">
    <input type="password" name="password" id="">
    <input type="password" name="password_confirmation" id="">
    <input type="submit">
</form>
<hr>
<a href="{{ route('login.index')}}"></a>
@endsection
