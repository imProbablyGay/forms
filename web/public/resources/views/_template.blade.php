<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content=" {{ csrf_token() }} ">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="/js/functions.js" defer></script>
    @if (request()->route()->getName() == 'edit_profile_data.edit')
        <link rel="stylesheet" href="/dist/cropper/cropper.min.css">
        <script src="/dist/cropper/cropper.min.js" defer></script>
        <script src="/js/uploadIcon.js" defer></script>
    @elseif (request()->route()->getName() == 'create_form.index')
        <script src="https://cdn.tiny.cloud/1/d6cgt3veoxqgph1gof0h81iuu47ufm0ot3ufaownd0l4he82/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="/js/createForm.js" defer></script>
    @elseif (request()->route()->getName() == 'answer_form.index')
        <script src="/js/modules/_displayPublishedForm.js" defer></script>
        <script src="/js/createAnswer.js" defer></script>
    @elseif (request()->route()->getName() == 'profile.index')
        <script src="/js/profile.js" defer></script>
    @elseif (request()->route()->getName() == 'profile.show_form')
        <script src="/js/modules/_displayPublishedForm.js" defer></script>
        <script src="/js/showProfileForm.js" defer></script>
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>@yield('title')</title>
</head>
<body>
    {{-- header --}}
<header>
    <nav class="fixed-top navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">Форма</a>
            @if(Auth::user())
            {{-- profile --}}
            <a class="navbar__profile" href="{{route('profile.index')}}">
                <img class='profile-picture' src="/img/users/icons/{{Auth::user()['id']}}.jpeg" alt="">
                <span>{{Auth::user()['name']}}</span>
            </a>
            @else
            {{-- login --}}
            <a class="navbar__login" href='{{route('login.index')}}'>Войти</a>
            @endif
        </div>
      </nav>
</header>

    {{-- success modal --}}
<div class="modal fade" id="alert_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding:10px;">
        <div class="modal-body text-center">
            <h4></h4>
        </div>
        <div class="modal-footer" style="justify-content:center;">
            <button type="button" class="btn modal-close-footer" data-bs-dismiss="modal">Закрыть</button>
        </div>
        </div>
    </div>
    </div>

    {{-- confirm/reject modal --}}
<div class="modal fade" id="confirm_reject_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding:10px;">
        <div class="modal-body text-center">
            <h4></h4>
        </div>
        <div class="modal-footer" style="justify-content:center;">
            <button type="button" class="btn modal-send-footer" data-bs-dismiss="modal">Да</button>
            <button type="button" class="btn modal-close-footer" data-bs-dismiss="modal">Нет</button>
        </div>
        </div>
    </div>
    </div>


<div class="page">
    @yield('main')
</div>


{{-- footer --}}
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 footer__copy">
                <span>ARTJOM, &copy;{{now()->year}}</span>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
