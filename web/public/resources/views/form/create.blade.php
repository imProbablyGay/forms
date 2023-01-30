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
                <div class="question__text">
                    <h5>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nisi cumque ab totam commodi ullam porro doloremque earum voluptatem unde laboriosam.</h5>
                </div>

                <div class="question__options ">
                    <div class="question__option option">
                            <label class="checkbox">
                                <input type="radio" checked="checked" disabled>
                                <span class="checkmark"></span>
                              </label>
                        <input type="text" placeholder="Введите значение">
                    </div>

                    <div class="question__option">
                        <label class="radio">
                            <input type="checkbox" checked="checked" disabled>
                            <span class="checkmark"></span>
                          </label>
                        <input type="text" placeholder="Введите значение">
                    </div>


                </div>
                <div class="question__controls">
                    <div class="d-flex">
                        <div class="question__edit">
                            <button>Изменить</button>
                        </div>
                        <div class="question__option-add option__add">
                            <div class="option__add-options">
                                <div class="option__add-option" data-add-option-type='custom'>Добавить&nbspответ</div>
                                <div class="option__add-option" data-add-option-type='another'>Добавить&nbsp"другое"</div>
                            </div>
                        </div>
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
            <div class="col-12">
                <button type='button' class="new-question__add btn btn-primary">Добавить вопрос</button>
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
                <h6>Тип вопроса:</h6>
                <div class="new-question__options">
                    @foreach ($q_types as $type)
                    <div class="new-question__option" data-type='{{$type->id}}'>{!! html_entity_decode($type->type) !!}</div>
                    @endforeach
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
          <button type="button" class="btn modal-send-footer d-none new-question__show" data-bs-dismiss="modal">Применить</button>
          <button type="button" class="btn modal-close-footer" data-bs-dismiss="modal">Отменить</button>
        </div>
      </div>
    </div>
  </div>
@endsection

