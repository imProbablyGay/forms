@extends('_template')

@section('title')
главная
@endsection

@section('main')

<div class="container home">
    <div class="row">
        <div class="col-12 home__title">
            <h1>Создай свою форму уже сейчас!</h1>
            <span>этот сервис поможет тебе создавать опросники абсолютно бесплатно!</span>
            <a href="{{route('register.index')}}" class="btn-create home__register">создай аккаунт сейчас</a>
        </div>
    </div>
</div>

@endsection
