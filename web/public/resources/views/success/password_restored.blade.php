@if (session('password_restored'))
    @extends('_template')

    @section('title')
    Пароль восстановлен
    @endsection

    @section('main')

    <div class="restored-password">
        <div class="container">
            <div class="col-12 justify-content-center d-flex">
                <div class="restored-password__message">
                    <span>Ваш пароль успешно восстановлен, эту вкладку можно закрыть.</span>
                </div>
            </div>
        </div>
    </div>

    @endsection
@else
<script>window.location = "{{ route('not_found') }}";</script>
@endif
