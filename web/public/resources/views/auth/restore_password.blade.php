@extends('_template')

@section('title')
hui 2
@endsection

@section('main')

<h1>resote</h1>

@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif

<div class="restore__password">
    <form action="/password/restore_process/{{$restore}}" method="post" id="restorePassword">
        @csrf
        <input type="password" name="password" id="">
        <input type="password" name="password_confirmation" id="">
        <input type="submit">
    </form>
</div>

<hr>
@endsection

<script>
</script>
