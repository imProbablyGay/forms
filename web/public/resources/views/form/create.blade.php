@extends('_template')

@section('title')
новая форма
@endsection

@section('main')

<h1>новая форма</h1>

@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif

</div>

<hr>


{{-- change icon --}}
<button type="button" class="btn btn-primary">
    add question
  </button>

<div class="container">
    <div class="row">
        <div class="modal" tabindex="-1" id='upload_new_form_modal'>
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Новый вопрос</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form">
                    <div class="form__controls">
                        <h6>Тип вопроса:</h6>
                        <div class="form__options">
                            @foreach ($q_types as $type)
                            <div class="form__option" data-type-id='{{$type->id}}'><span> {!! html_entity_decode($type->type) !!} </span></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form__textarea">
                        <textarea id="uploadForm"></textarea>
                        <div class="form__count count d-flex">
                            <div class="count__text"><span></span></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn modal-send-footer d-none" data-bs-dismiss="modal">Применить</button>
                  <button type="button" class="btn modal-close-footer" data-bs-dismiss="modal">Отменить</button>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection

