@extends('_template')

@section('title')
Восстановить пароль
@endsection

@section('main')

<div class="forgot-password">
    <div class="container">
        <div class="row">
            {{-- email sent --}}
            @if (session('success'))

            <div class="col-12 justify-content-center d-flex">
                <div class="forgot-password__message">
                    <span>{{session('success')}}</span>
                </div>
            </div>


            @else

            {{-- forgto password form --}}
            <div class="forgot-password__title text-center">
                <h2>Восстановить пароль</h2>
            </div>
            <div class="col-12 justify-content-center d-flex">
                <form action="{{route('forgot_password.store')}}" method="post" class="forgot-password__form">
                    @csrf

                    {{-- name --}}
                    <div class='forgot-password__input'>
                        @if($errors->has('email'))
                            <span class="forgot-password__error">{{ $errors->first('email') }}</span>
                        @endif
                        <input type="text" name="email" id="" placeholder="E-mail пользователя">
                    </div>

                    <div class="forgot-password__submit">
                        <input type="submit" value="Восстановить пароль">
                    </div>

                </form>
            </div>

            @endif

        </div>
    </div>
</div>

@endsection
