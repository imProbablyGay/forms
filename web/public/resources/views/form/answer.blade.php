@extends('_template')

@section('title')
ответить на форму
@endsection

@section('main')
<div class="container form">
    <div class="row">
        <div class="form__author text-center">
            <img class='profile-picture' src="/img/users/icons/{{$description['user_id']}}.jpeg" alt="">
            <h5>{{$description['user_name']}}</h5>
        </div>
        <div class="form__title col-12">
            <h2></h2>
        </div>
    </div>

    <div class="questions questions-answer">
    </div>

    <div class="questions-answer__create row">
        <div class="col-md-6 col-12">
            <button type='button' class="btn-create answer__create">Отправить форму</button>
        </div>
    </div>
</div>

@endsection
