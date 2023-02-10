@extends('_template')

@section('title')
новая форма
@endsection

@section('main')


@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif

<div class="container form">
    <div class="row form__title text-center">
        <div class="form__title col-12">
            <h2>Здесь вы можете создать новую форму для опроса</h2>
        </div>
    </div>

    <div class="questions">
        <div class="questions__spot">
            <div class="question">
                <div class="question__text"></div>

                <div class="question__options" data-question-type=''>
                    <div class="question__option option">
                        <label class="">
                            <input type="" checked="checked" disabled>
                            <span class="checkmark"></span>
                            </label>
                        <input class='option__input' maxlength="1000" type="text" placeholder="Введите значение">
                        <div class="option__delete">
                            <div class="cross-close"></div>
                        </div>
                    </div>

                    <div class="question__option option">
                        <label class="">
                            <input type="" checked="checked" disabled>
                            <span class="checkmark"></span>
                          </label>
                        <input class='option__input' maxlength="1000" type="text" placeholder="Введите значение">
                        <div class="option__delete">
                            <div class="cross-close"></div>
                        </div>
                    </div>
                </div>
                <div class="question__options-add options__add">
                    <div class="option__add" data-option-type='custom'><span>Добавить вариант</span></div>
                    <div class="option__add option__add-another" data-option-type='another'><span>Добавить "другое"</span></div>
                </div>
                <div class="question__controls">

                    <div class="dropdown dropup">
                        <div class="question__settings" id="question-settings" data-bs-toggle="dropdown" aria-expanded="false"><div></div><div></div><div></div></div>
                        <ul class="dropdown-menu" aria-labelledby="question-settings">
                          <li class="question__edit dropdown-item">Изменить</li>
                          <li class="dropdown-item question__delete">Удалить <img src="/img/usage/rubbish-bin.svg" width='17'></li>
                        </ul>
                      </div>

                    <div class="question__requirable text-end">
                        <span>Обязятельный вопрос</span>
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                          </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row question__create">
            <div class="col-md-6 col-12">
                <button type='button' class="new-question__add btn btn-primary">Добавить вопрос</button>
            </div>

            <div class="col-md-6 col-12">
                <button type='button' class="form__create btn btn-primary">Создать форму</button>
            </div>
        </div>
    </div>
</div>


{{-- form modal --}}
<div class="modal" tabindex="-1" id='upload_new_question_modal'>
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Новый вопрос</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body new-question">
            <div class="new-question__controls">


                <div class=" new-question__type dropdown" id="dropdown">
                    <div class="dropdown-toggle" id="upload-question-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class='new-question__type-option' data-type='radio'>
                            <label class="radio">
                            <input type="radio" checked="checked" disabled>
                            <span class="checkmark"></span>
                            </label>
                            <span class="new-question__option-value">Один из списка</span>
                        </span>
                    </div>
                    <ul class="dropdown-menu">
                      <li class="dropdown-item d-none">
                        <span class='new-question__type-option' data-type='radio'>
                            <label class="radio">
                            <input type="radio" checked="checked" disabled>
                            <span class="checkmark"></span>
                            </label>
                            <span class="new-question__option-value">Один из списка</span>
                        </span>
                      </li>
                      <li class="dropdown-item">
                        <span class='new-question__type-option' data-type='checkbox'>
                            <label class="checkbox">
                            <input type="checkbox" checked="checked" disabled>
                            <span class="checkmark"></span>
                            </label>
                            <span class="new-question__option-value">Несколько из списка</span>
                        </span>
                      </li>
                      <li class="dropdown-item d-flex">
                        <span class='new-question__type-option' data-type='text'>
                            <div class='new-question__option-value-text'>
                                <div>T</div>
                            </div>
                            <span class="new-question__option-value">Tекстовое поле</span>
                        </span>
                    </li>
                    </ul>
                  </div>



            </div>

            <div class="new-question__textarea">
                <textarea id="uploadQuestion"></textarea>
                <div class="new-question__count count d-flex">
                    <div class="count__text"><span></span></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn modal-send-footer d-none new-question__show" >Применить</button>
          <button type="button" class="btn modal-close-footer" data-bs-dismiss="modal">Отменить</button>
        </div>
      </div>
    </div>
  </div>
@endsection

