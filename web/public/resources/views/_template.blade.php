<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content=" {{ csrf_token() }} ">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="/js/functions.js" defer></script>
    @if (request()->route()->getName() == 'show_profile_edit')
        <link rel="stylesheet" href="/dist/cropper/cropper.min.css">
        <script src="/dist/cropper/cropper.min.js" defer></script>
        <script src="/js/uploadIcon.js" defer></script>
    @elseif (request()->route()->getName() == 'show_create_form')
        <script src="https://cdn.tiny.cloud/1/d6cgt3veoxqgph1gof0h81iuu47ufm0ot3ufaownd0l4he82/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="/js/createForm.js" defer></script>
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>@yield('title')</title>
</head>
<body>
@yield('main')
</body>
</html>
