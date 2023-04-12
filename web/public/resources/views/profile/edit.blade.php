@extends('_template')

@section('title')
Редактировать профиль
@endsection

@section('main')

<div class="profile-edit">
    <div class="container">
        <div class="row">
            <div class="profile-edit__title text-center">
                <h2>Редактировать профиль</h2>
            </div>
            <div class="col-12 justify-content-center d-flex">
                <form action="{{route('edit_profile_data.update')}}" method="post" class="profile-edit__form" id="form">
                    @csrf

                    {{-- update icon --}}
                    <div class="profile-edit__icon">
                        <img class='profile-picture' src="/img/users/icons/{{auth()->user()->id}}.jpeg" alt=""><br>

                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#upload_icon_modal">
                            Поменять иконку
                          </button>
                    </div>

                    {{-- new name --}}
                    <div class='profile-edit__input' >
                        <span class="profile-edit__label">Поменять имя пользователя</span><br>
                        @if($errors->has('name'))
                            <span class="profile-edit__error">{{ $errors->first('name') }}</span>
                        @endif
                        <input type="text" name="name" placeholder="Новое имя" value='@if(!$errors->has('name')){{$user['name']}}@endif'>
                    </div>

                    {{-- new email --}}
                    <div class='profile-edit__input'>
                        <span class="profile-edit__label">Поменять e-mail</span><br>
                        @if($errors->has('email'))
                            <span class="profile-edit__error">{{ $errors->first('email') }}</span>
                        @endif
                        <input type="email" name="email" placeholder="Новый e-mail" value='@if(!$errors->has('email')){{$user['email']}}@endif'>
                    </div>

                    {{-- new password --}}
                    <div class='profile-edit__input'>
                        <span class="profile-edit__label">Поменять пароль</span><br>
                        @if($errors->has('password'))
                            <span class="profile-edit__error">{{ $errors->first('password') }}</span>
                        @endif
                        <input type="password" name="password" placeholder="Новый пароль">
                    </div>

                    <div class="profile-edit__submit">
                        <input type="submit" value="Применить">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- success modal --}}
  <div class="modal fade" id="success_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="padding:10px;">
        <div class="modal-body text-center">
          <h4>Данные успешно изменены</h4>
        </div>
        <div class="modal-footer" style="justify-content:center;">
          <button type="button" class="btn modal-close-footer" data-bs-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

{{-- show success modal --}}
@if(session('success'))
    <script>
        let successModal = new bootstrap.Modal(document.getElementById('success_modal'));
        successModal.show()
    </script>
@endif


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
