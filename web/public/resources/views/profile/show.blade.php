@extends('_template')

@section('title')
профиль
@endsection

@section('main')

<div class="profile">
    <div class="container">
        <div class="row">
            <div class="col-12 profile__title">
                <img class="profile-picture" src="/img/users/icons/{{Auth::user()['id']}}.jpeg" alt="">
                <h2>{{Auth::user()['name']}}</h2>
            </div>
        </div>

        <div class="profile__controls">
            <a href="{{route('edit_profile_data.edit')}}">
                Редактировать профиль
            </a>
            <a href="{{route('logout.index')}}">
                Выйти из аккаунта
            </a>
            <a class='profile__controls-form' href="{{route('create_form.index')}}">
                Создать форму
            </a>
        </div>

        {{-- display users forms --}}
        <div class="profile__forms">
            <div class="profile__forms-title">
                <h5>Ваши формы: <span>{{$forms_count}}</span></h5>
            </div>
            <div class="profile__forms-place">
                {{-- insert via js --}}
            </div>
        </div>
    </div>
</div>

@endsection
