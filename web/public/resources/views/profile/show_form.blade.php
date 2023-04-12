@extends('_template')

@section('title')
ваша форма
@endsection

@section('main')
<div class="container form profile profile-form">

    {{-- copy form link --}}
    <div class="row">
        <div class="col-12 text-center">
            <button class='btn-create profile-form__copy-link' data-copy-link='{{$copy_link}}'>Скопировать ссылку формы</button>
        </div>
    </div>

    <div class="row">
        <div class="controls col-12 text-center">
            <span class="controls__item active" data-form-action='statistics'>Статистика</span>

            @if ($answers_amount > 0)
            / <span class="controls__item" data-form-action='certain_answer'>Ответы</span>
            @endif
        </div>
    </div>

    <div class="profile-form__tabs">
        {{-- show questions --}}
        <div class="profile-form__statistics statistics" data-form-tab='statistics'>
            {{-- total amount --}}
            <div class="row">
                <div class="col-12 statistics__amount controls text-center">
                    <b>Количество ответов на вашу форму: {{$answers_amount}}</b>
                </div>
            </div>
            {{-- show title --}}
            <div class="row">
                <div class="form__title col-12">
                    <h2></h2>
                </div>
            </div>
            <div class="questions statistics__questions" data-form-tabs-questions='statistics'>
            </div>
        </div>

        {{-- show answers --}}
        @if ($answers_amount > 0)
        <div class="profile-form__certain-answer certain-answer d-none" data-form-tab='certain_answer'>
            <div class="certain-answer__controls controls text-center">
                <b>Ответ номер <input type="number" value='1' min='1' max='{{$answers_amount}}'> из {{$answers_amount}}</b>
            </div>
            <div class="certain-answer__date">
                <b></b>
            </div>
            {{-- show title --}}
            <div class="row">
                <div class="form__title col-12">
                    <h2></h2>
                </div>
            </div>
            <div class="questions certain-answer__questions" data-form-tabs-questions='certain_answer'></div>
        </div>
        @endif
    </div>


    {{-- return back --}}
    <div class="profile__form row">
        <div class="col-md-6 col-12">
            <button type='button' class="btn-create profile__back-btn">Назад</button>
        </div>
    </div>
</div>

@endsection
