<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posterz</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://use.fontawesome.com/95a8335500.js"></script>
</head>
<body>
<div id="app">
    @if (!\Illuminate\Support\Facades\Auth::check())
        <script src="//ulogin.ru/js/ulogin.js"></script>
    @endif
    <app></app>
</div>
<script>
    var csrf_token = '{{ csrf_token() }}'
    @if (\Illuminate\Support\Facades\Auth::check())
        var user = {!! json_encode(\Illuminate\Support\Facades\Auth::user()->secureUser()) !!}
    @else
        var user = false
    @endif
</script>
<script src="/js/app.js"></script>
</body>
</html>
