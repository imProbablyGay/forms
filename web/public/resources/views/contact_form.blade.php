@extends('_template')

@section('title')
hui 2
@endsection

@section('main')
<h1>contact form</h1>

@if (session('sent'))
    <h2> message sent</h2>
@endif

<form action="{{ route('contact_form_process')}}" method="post">
    @csrf
    <input type="text" name="email" id="">
    <input type="text" name="text" id="">
    <input type="submit">
</form>
<hr>
@endsection
