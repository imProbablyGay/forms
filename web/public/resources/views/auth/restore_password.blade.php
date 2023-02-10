@extends('_template')

@section('title')
Восстановить пароль
@endsection

@section('main')


{{-- forgto password form --}}
<div class="restore-password">
    <div class="container">
        <div class="row">
            <div class="restore-password__title text-center">
                <h2>Восстановить пароль</h2>
            </div>
            <div class="col-12 justify-content-center d-flex">
                <form action="{{route('restore_password.restore', ['link' => $restore])}}" method="post" class="restore-password__form">
                    @csrf

                    {{-- new password --}}
                    <div class='restore-password__input'>
                        @if($errors->has('password'))
                            <span class="restore-password__error">{{ $errors->first('password') }}</span>
                        @endif
                        <input type="password" name="password" id="" placeholder="Придумайте новый пароль">
                    </div>

                    <div class='restore-password__input'>
                        <input type="password" name="password_confirmation" id="" placeholder="Повторите новый пароль">
                    </div>

                    <div class="restore-password__submit">
                        <input type="submit" value="Восстановить пароль">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
