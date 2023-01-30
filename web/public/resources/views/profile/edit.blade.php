@extends('_template')

@section('title')
hui 2
@endsection

@section('main')
<h1>edit</h1>
<form id='form'>
    <input type="text" name="username" id="username" value="{{$user['name']}}">
    <input type="email" name="email" id="email" value="{{$user['email']}}">
    <input type="password" name="password" id="password" placeholder="сменить пароль">
    <input type="submit">
</form>
<hr>

{{-- change icon --}}
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#upload_icon_modal">
    change icon
  </button>

<div class="container">
    <div class="row">
        <div class="modal" tabindex="-1" id='upload_icon_modal'>
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Выберите новую картинку</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body change-icon">
                    <input type="file" multiple accept="image/*" id="f" class="upload-inp" style='display:none;'>
                    <label for="f" class='change-icon__btn'>Здесь</label>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn modal-send-footer d-none" id='acceptNewIcon' data-bs-dismiss="modal">Применить</button>
                  <button type="button" class="btn modal-close-footer" data-bs-dismiss="modal">Отменить</button>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>



@endsection