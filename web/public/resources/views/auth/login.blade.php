@extends('_template')

@section('title')
Войти в аккаунт
@endsection

@section('main')

<div class="login">
    <div class="container">
        <div class="row">
            <div class="login__title text-center">
                <h2>Войти в аккаунт</h2>
            </div>
            <div class="col-12 justify-content-center d-flex">
                <form action="{{route('login.login')}}" method="post" class="login__form">
                    @csrf
                    {{-- wrong data --}}
                    <div class="">
                        @if(session('wrong_data'))
                            <span class="login__error">{{ session('wrong_data') }}</span>
                        @endif
                    </div>

                    {{-- name --}}
                    <div class='login__input'>
                        @if($errors->has('name'))
                            <span class="login__error">{{ $errors->first('name') }}</span>
                        @endif
                        <input type="text" name="name" id="" placeholder="Имя или e-mail пользователя">
                    </div>

                    {{-- password --}}
                    <div class='login__input'>
                        @if($errors->has('password'))
                            <span class="login__error">{{ $errors->first('password') }}</span>
                        @endif
                        <input type="password" name="password" id="" placeholder="Пароль">
                    </div>

                    {{-- remembter user --}}
                    <div class="login__remember">
                        <label class="checkbox"><span class="login__remember-text">Запомнить меня</span>
                            <input type="checkbox">
                            <span class="checkmark"></span>
                          </label>
                    </div>

                    <div class="login__submit">
                        <input type="submit" value="Войти">
                    </div>

                    <div class="text-center login__register">
                        <p>Еще нет аккаунта <a href="{{route('register.index')}}">зарегестрироваться</a></p>
                    </div>

                    <div class="text-center">
                        <a href="{{route('forgot_password.index')}}">Забыл пароль</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
