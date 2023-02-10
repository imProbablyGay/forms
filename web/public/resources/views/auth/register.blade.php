@extends('_template')

@section('title')
Создать аккаунт
@endsection

@section('main')


<div class="register">
    <div class="container">
        <div class="row">
            <div class="register__title text-center">
                <h2>Зарегестрироваться</h2>
            </div>
            <div class="col-12 justify-content-center d-flex">
                <form action="{{route('register.register')}}" method="post" class="register__form">
                    @csrf

                    {{-- email --}}
                    <div class='register__input'>
                        @if($errors->has('email'))
                            <span class="register__error">{{ $errors->first('name') }}</span>
                        @endif
                        <input type="text" name="email" id="" placeholder="Ваш e-mail">
                    </div>

                    {{-- name --}}
                    <div class='register__input'>
                        @if($errors->has('name'))
                            <span class="register__error">{{ $errors->first('name') }}</span>
                        @endif
                        <input type="text" name="name" id="" placeholder="Имя пользователя">
                    </div>

                    {{-- password --}}
                    <div class='register__input'>
                        @if($errors->has('password'))
                            <span class="register__error">{{ $errors->first('password') }}</span>
                        @endif
                        <input type="password" name="password" id="" placeholder="Пароль">
                    </div>

                    {{-- password --}}
                    <div class='register__input'>
                        <input type="password" name="password_confirmation" id="" placeholder="Повторите пароль">
                    </div>

                    <div class="register__submit">
                        <input type="submit" value="Создать аккаунт">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
