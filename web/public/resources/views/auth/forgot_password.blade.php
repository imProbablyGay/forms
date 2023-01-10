@extends('_template')

@section('title')
hui 2
@endsection

@section('main')
<h1>forgot</h1>
@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@elseif(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form action="{{ route('forgot_password_process')}}" method="post">
    @csrf
    <input type="text" name="email" id="">
    <input type="submit">
</form>
<hr>
@endsection

<script>
// setTimeout(() => {
//     let data = {
//         'name': 'my first form',
//         'questions': [
//             {
//                 'text': 'question text 1',
//                 'type': '1',
//                 'is_required': true,
//                 'options': [
//                     {'value': null}
//                 ]
//             },
//             {
//                 'text': 'question text 2',
//                 'type': '2',
//                 'is_required': false,
//                 'options': [
//                     {'value': 'value 1'},
//                     {'value': 'value 2'},
//                     {'value': 'value 3'},
//                 ]
//             }
//         ]
//     };


//     fetch('/upload_form_process', {
//         method: "POST",
//         headers: {
//             'Accept': 'application/json',
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({"form":data, "_token":  document.querySelector('meta[name="csrf-token"]').getAttribute('content')}),
//     })
//     .then(data => data.text())
//     .then(data => console.log(data))
// }, 0);
</script>
