@if (session('password_restored'))
    @extends('_template')

    @section('title')
    пароль восстановлен
    @endsection

    @section('main')

    <h1>Ваш пароль восстановлен</h1>
    <p>Эту вкладку можно закрыть</p>
    @endsection
@else
<script>window.location = "{{ route('not_found') }}";</script>
@endif
